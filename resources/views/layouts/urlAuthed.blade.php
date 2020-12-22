<script>
    window.notTrip = "{{URL::asset('images/icons/KOFAV0.svg')}}";
    window.GetMyTripsUrl = '{{route('myTrips.getTrips')}}';
    window.GetBookMarkUrl = '{{route("profile.getBookMarks")}}';

    window.user = {!! $authUserInfos !!};
</script>