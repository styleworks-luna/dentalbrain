<?php


namespace App\Services\Program;


use App\Models\File;
use App\Models\Program\Lecture;
use App\Models\Program\Program;
use App\Services\File\LectureThumbnail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OnlineProgramConcrete extends ProgramTemplate
{
    public function __construct()
    {
        $is_online = true;
        parent::__construct($is_online);
    }

    /**
     * @param Program $program
     * @param array $dataSet
     * @return array
     */
    public function storeLectures(Program $program, $dataSet)
    {
        $returnableDataSet = [];
        foreach ($dataSet as $data) {
            $lecture = Lecture::create([
                'program_id' => $program->id,
                'thumbnail_id' => $data['thumbnail_id'] ?? null,
                'youtube_id' => ($data['vidoe_type'] == 'wecandeo'?(Lecture::getWecandeoIdFromUrl($data['url'])):(Lecture::getYoutubeIdFromUrl($data['url']))),
                'url' => $data['url'],
                'title' => $data['title'],
                'vidoe_type' => ($data['vidoe_type'] == 'wecandeo'?'wecandeo':'youtube'),
            ]);
            if (isset($data['thumbnail_id'])) {
                $fileService = new LectureThumbnail($lecture);
                $fileService->moveTempToPublic(File::find($data['thumbnail_id']));
            }
            $returnableDataSet[] = $lecture;

        }
        return $returnableDataSet;
    }

    /**
     * Lecture validate
     *
     * @param Request $request
     * @param array $additionalRules
     * @return array
     */
    public function validateLectures($request, array $additionalRules = [])
    {
        $v = Validator::make($request->all(), array_merge([
            'lectures.*.title' => ['required', 'string'],
            'lectures.*.url' => ['required', 'url'],
            'lectures.*.thumbnail_id' => ['nullable', 'numeric'],
            'lectures.*.vidoe_type' => ['required', 'string'],
            'lectures' => ['required', 'array']
        ], $additionalRules));
        $validatedData = $v->validate();

        return $validatedData['lectures'];
    }

    public function updateLectures(Program $program, array $dataSet)
    {
        $returnableDataSet = [];
        $originalLectureIds = $program->lectures()->pluck('id');

        foreach ($dataSet as $data) {
            if (isset($data['id'])) {
                // 기존 항목
                $lecture = Lecture::find($data['id']);

                if ($lecture->thumbnail_id != $data['thumbnail_id']) {
                    // 기존과 썸네일이 다른 경우
                    $fileService = new LectureThumbnail($lecture);

                    // 기존 썸네일 삭제
                    if ($lecture->thumbnail != null) {
                        $fileService->deleteFile();
                    }

                    if ($data['thumbnail_id'] !== null) {
                        //새로 수정한 썸네일이 있는 경우
                        $file = $fileService->moveTempToPublic(File::find($data['thumbnail_id']));
                        if ($file == false) {
                            throw new Exception('LECTURE THUMBNAIL UPDATE ERROR');
                        }
                    }
                }

                $lecture->update([
                    'program_id' => $program->id,
                    'thumbnail_id' => $data['thumbnail_id'],
                    'youtube_id' => ($data['vidoe_type'] == 'wecandeo'?(Lecture::getWecandeoIdFromUrl($data['url'])):(Lecture::getYoutubeIdFromUrl($data['url']))),
                    'url' => $data['url'],
                    'title' => $data['title'],
                    'vidoe_type' => $data['vidoe_type'],
                ]);

            } else {
                // 새 항목 ( 저장과 똑같은 플로우.
                $lecture = Lecture::create([
                    'program_id' => $program->id,
                    'thumbnail_id' => $data['thumbnail_id'],
                    'youtube_id' => ($data['vidoe_type'] == 'wecandeo'?(Lecture::getWecandeoIdFromUrl($data['url'])):(Lecture::getYoutubeIdFromUrl($data['url']))),
                    'url' => $data['url'],
                    'title' => $data['title'],
                    'vidoe_type' => $data['vidoe_type'],
                ]);

                if ($data['thumbnail_id'] != null) {
                    $fileService = new LectureThumbnail($lecture);
                    $file = $fileService->moveTempToPublic(File::find($data['thumbnail_id']));
                    if ($file == false) {
                        throw new Exception('LECTURE NEW THUMBNAIL  ERROR');
                    }
                }
            }

            $returnableDataSet[] = $lecture;
        }

        // 삭제 할 강의 추려내기.
        $newLectureIds = collect($returnableDataSet)->pluck('id');
        $deletable = $originalLectureIds->diff($newLectureIds);

        // 강의 썸네일 삭제.
        $deletableThumbnails = Lecture::query()->whereIn('id', $deletable)
            ->whereNotNull('thumbnail_id')
            ->get()
            ->mapInto(LectureThumbnail::class);
        $deletableThumbnails->each(function (LectureThumbnail $item, $key) {
            $item->deleteFile();
        });

        // 강의 DB 삭제.
        Lecture::query()->whereIn('id', $deletable)->delete();

        return $returnableDataSet;
    }
}
