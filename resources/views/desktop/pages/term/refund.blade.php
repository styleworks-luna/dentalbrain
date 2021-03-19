@extends('desktop.layouts.frames.basic_frame')

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/term/term-common.css') }}">
@endsection

@section('content')
    <section class="term">
        <div class="container">
            @include('desktop.layouts.navigation.term')

            <div class="content">
                <h5>오프라인 강의 수강취소와 환불정책</h5>
                <ul>
                    <li>• 수강신청 후 강의 시작 전일 취소할 경우 전액 환불을 진행합니다. 단) 교재가 있는 강의 일 경우 교재비 비용 부담을 원칙으로 합니다. 나머지 비용을 환불처리 합니다.</li>
                    <li>• 강의 당일 취소 할 경우 환불이 불가능 합니다.</li>
                    <li>• 환불이 발생 된 경우에는 5 영업일 이내 금액이 환불됩니다.</li>
                </ul>

                <h5>온라인 강의 수강취소와 환불정책</h5>
                <ul>
                    <li>• 수강시작일은 결제일자를 기준으로 합니다.</li>
                    <li>• 수강시작을 위해 강의를 오픈 한 경우에는 환불이 불가능 합니다.</li>
                    <li>• 수강시작을 하고 강의 오픈을 하지 않은 경우에는 반환 사유 발생 시 5 영업일 이내  금액이 환불됩니다.
                    <li>• 공통) PG사와 카드사의 상황에 따라 환불이 지연될 수 있습니다.</li>
                    <li>• 온라인 강의는 각 과정 별 '정상 수강기간(유료수강기간)'과 정상 수강기간 이후의 '복습 수강기간(무료수강기간)'으로 구성됩니다.</li>
                    <li>• 일부 과정은 '정상 수강기간'에만 수강 가능하며 복습(무료)수강기간을 제공하지 않습니다. (예 : 자격시험 교육과정).</li>
                </ul>

                <h5>폐강이 진행 될 경우 폐강 시 처리 기준</h5>
                <ul>
                    <li>• 오프라인 강의인 경우 모집된 수강인원이 10명 이하일 경우</li>
                    <li>• 강사의 갑작스러운 사고 및 건강 상의 이유</li>
                    <li>• 천재지변</li>
                    <li>• 학원법 제 18조에 따라 오프라인 강의 취소/환불 정책을 준용하여 환불 처리되며, 모객 부진으로 폐강 시에는 최소 개강일로부터 5일 전에는 폐강 여부를 안내해드립니다.</li>
                </ul>
            </div>

        </div>
    </section>
@endsection
