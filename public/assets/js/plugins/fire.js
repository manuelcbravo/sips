var page = 1;

const url = document.currentScript.getAttribute('url')
const cross = document.currentScript.getAttribute('cross')

$('.card-body-height').on('scroll', function() {
    if(Math.round($(this).scrollTop() + $(this).innerHeight(), 10) >= Math.round($(this)[0].scrollHeight, 10) ) {
        console.log( Math.round($(this)[0].scrollHeight, 10), Math.round($(this).scrollTop() + $(this).innerHeight(), 10))
        page++;
        notifitions();
    }
});


function notifitions(){
    var a=[];$.ajax({url: url + "/notificaciones/"+ cross +"?page="+page,type:"get",async:!1,cache:!1,beforeSend: function(){
            $('#spinnerNList').show();
        },success:function(b){
            var all_notificaciones = b.notificaciones.data;

            if(b.visto == 1){
                $('#status_notificacion').hide();
            }

            if(all_notificaciones.length > 0) {
                $('#no_notificaciones').hide();
            }
            $.each(all_notificaciones, function(index, value) {
                $('.nav_notifications').append(`<li class="list-group-item form-check-select">
                                                    <div class="row">
                                                       <div class="col-auto">
                                                            <div class="d-flex align-items-center">
                                                              <div class="avatar avatar-sm avatar-soft-dark avatar-circle">
                                                                <span class="avatar-initials">${ value.nombre_completo[0]}</span>
                                                              </div>
                                                            </div>
                                                          </div>
                                                          <div class="col ms-n2">
                                                            <h5 class="mb-1">${ value.nombre_completo}</h5>
                                                            <p class="text-body fs-5">${ value.notificacion}</p>
                                                          </div>
                                                        <small class="col-auto text-muted text-cap">${moment(value.created_at).fromNow()}</small>
                                                    </div>
                                                </li>`)
            });

        },
        complete: function (){
            $('#spinnerNList').hide();
        }});

}

notifitions();

$("#navbarNotificationsDropdown").on('click', function(event){
    $.ajax({
        url: url+'/helper/'+cross+'/visto',
        type: 'get',
        dataType: 'JSON',
        success: function (response) {
            $('#status_notificacion').hide();
        },
        error: function (err) {
            errorSwal('Error',error);
        },
    });
});

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
var firebaseConfig = {
    apiKey: "AIzaSyC7U4LSrCsi6iclTE2RKz8NGA_XIMX8-V4",
    authDomain: "newagent-mkgxje.firebaseapp.com",
    databaseURL: "https://newagent-mkgxje.firebaseio.com",
    projectId: "newagent-mkgxje",
    storageBucket: "newagent-mkgxje.appspot.com",
    messagingSenderId: "33777169695",
    appId: "1:33777169695:web:ff7d6974051fb2a263ac2a",
    measurementId: "G-QKZ1C334GB"
};
// Initialize Firebase
firebase.initializeApp(firebaseConfig);
const messaging = firebase.messaging();

function startFCM() {
    messaging
        .requestPermission()
        .then(function () {
            return messaging.getToken()
        })
        .then(function (response) {

            $.ajax({
                url: url+'/save-token',
                type: 'POST',
                data: {
                    token: response
                },
                dataType: 'JSON',
                success: function (response) {

                },
                error: function (error) {
                    // errorSwal('Error',error);
                },
            });
        }).catch(function (error) {
        errorSwal('Error',error);
    });
}
messaging.onMessage(function (payload) {
    $('.nav_notifications').empty()
    $('#status_notificacion').show();
    page = 1
    notifitions()

    const title = payload.notification.title;
    const options = {
        body: payload.notification.body,
        icon: payload.notification.icon,
    };
    new Notification(title, options);
});
startFCM()