<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Episode;
use App\Youtube\YoutubeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CourseController extends Controller
{
    public function index() {
        $courses = Course::with('user')
            ->select("courses.*",DB::raw(
                "(SELECT COUNT(DISTINCT(user_id))
                      FROM complitition
                      INNER JOIN episodes on complitition.episode_id=episodes.id
                      where episodes.course_id=courses.id) as participants"
            ))
            ->addSelect(DB::raw(
                '
                (
                    select SUM(duration)
                    from episodes
                    where episodes.course_id=courses.id
                ) as total_duration
                '
            ))
            ->withCount('episodes')->latest()
            ->paginate(5);
        return Inertia::render("Courses/index",[
            'courses' => $courses
        ]);
    }

    public function show($id)
    {
        $course = Course::where('id',$id)->with('episodes')->get()->first();
        $watched = auth()->user()->episodes()->get();
        //dd($watched);
        return Inertia::render("Courses/show",[
            'course' => $course,
            'watched' => $watched
        ]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function toogleEpisode(Request $request):mixed
    {
        $id = $request->input('episodeId');
        $user = auth()->user();
        $user->episodes()->toggle($id);
        return $user->episodes;
    }

    public function saveFormations(Request $request,YoutubeService $youtube)
    {

        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'episodes' => ['required','array'],
            'episodes.*.title' => 'required',
            'episodes.*.description' => 'required',
            'episodes.*.video_url' => 'required|regex:/http(s?):\/\/www\.youtube\.com\/embed\/(.+)/'
        ]);
        //https://www.youtube.com/embed/yYEZOQVKy8w
        $course = Course::create($request->all());
        // dd($request->input('episodes'));
        foreach ($request->input('episodes') as $episode)
        {
            $duration =  $youtube->handleVideoDuration($episode['video_url']);
            $episode['course_id'] = $course->id;
            $episode['duration'] = $duration;
            $episode = Episode::create($episode);
        }
        return Redirect::route("dashboard")->with('success','La formation est mise en ligne avec success');
    }

    public function edit($id)
    {
        $course = Course::where('id',$id)->with('episodes')->get()->first();
        $this->authorize("update",$course);
        return Inertia::render("Courses/edit",[
            'course' => $course
        ]);
    }

    public function update(Request $request)
    {
        $course = Course::where('id',$request->id)->with('episodes')->get()->first();
        $this->authorize("update",$course);
        $course->update($request->all());
        $course->episodes()->delete();
        foreach ($request->input('episodes') as $episode)
        {
            $episode['course_id'] = $course->id;
            $episode = Episode::create($episode);
        }
        return Redirect::route('courses')->with('success',"La modification de l'episode est faite avec success");
    }
}
