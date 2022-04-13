<div class="title-wrap">
    <div class="container">
        <div class="albatalk-navigation">
            @inject('headerService', '\App\Services\Recruit\ResumeService')
            <a href="{{ route('albatalk.head-hunting') }}" target="_blank">헤드헌팅</a>
            <a href="{{ route('albatalk.recruit.create') }}">구인등록</a>
            @if( $headerService->existsResume() )
                <a href="{{ route('albatalk.resume.edit') }}">이력서 수정</a>
            @else
                <a href="{{ route('albatalk.resume.index') }}">이력서 등록</a>
            @endif
        </div>
    </div>
</div>
