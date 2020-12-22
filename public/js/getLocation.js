var pos;

function getCurrentLocation() {

    if (navigator.geolocation) {

        navigator.geolocation.getCurrentPosition(function(position) {

            pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };

            alert(pos.lat + " " + pos.lng);

        });
    } else {
        alert("Geolocation is not supported by this browser.");
    }
}