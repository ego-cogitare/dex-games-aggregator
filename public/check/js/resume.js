$(document).ready(function () {

    var navbar = $('.js_navbar');
    var errorsContainer = $('#errorsContainer');

    navbar.on('click', '.js_login', function(e) {
        e.preventDefault();
        show.login();
    });

    navbar.on('click', '.js_register', function(e) {
        e.preventDefault();
        show.register();
    });

    navbar.on('click', '.js_profile', function(e) {
        e.preventDefault();
        show.profile();
    });


    $.ajaxSetup({
        beforeSend: function (xhr) {
            errorsContainer.find('.alert').empty();
            errorsContainer.hide();
            if (localStorage.getItem('token')) {
                xhr.setRequestHeader('Authorization', 'Bearer '+localStorage.getItem('token'));
            }
        }
    });

    /**
     * Init
     */
    if (localStorage.getItem('token')) {
        show.profile();
    } else {
        show.login();
    }

    $(document).ajaxError(function( event, jqXHR, settings, thrownError ) {
        var errorBody = jQuery.parseJSON(jqXHR.responseText);
        //$('#errorsContainer').empty().html(errorBody.error);
        errorsContainer.find('.alert').empty().html(`<strong>${jqXHR.status}</strong>: ` + jqXHR.responseText);
        errorsContainer.show();
    });

});

var updateUse = () => {

}

var clearTemplate = function () {
    $('#mainContainer').empty().off().hide();
}

var mainContainer = $('#mainContainer');

var show = {
    register: () => {
        clearTemplate();
        mainContainer.html($('#view_register').html());
        mainContainer.on('click', '.js_register', function (e) {
            e.preventDefault();
            $.ajax({
                url: routes.auth_registration,
                method: 'POST',
                dataType: 'json',
                data: {
                    email: mainContainer.find('input[name=email]').val(),
                    password: mainContainer.find('input[name=password]').val(),
                    first_name: mainContainer.find('input[name=first_name]').val(),
                    last_name: mainContainer.find('input[name=last_name]').val(),
                    podcast_id: mainContainer.find('select[name=podcast_id]').val(),
                },
                success: (data) => {
                    show.login();
                },
                error: (data) => {
                    //show.register();
                },
            });
        });
        $.when( $.ajax(routes.podcast_index) ).done(function( podcast_index_data ) {
            for (var i = 0 ; i < podcast_index_data.list.length ; i++) {
                mainContainer.find('select[name=podcast_id]').append(`
                    <option value="${podcast_index_data.list[i].id}">${podcast_index_data.list[i].name}</option>
                `);
            }
            mainContainer.show();
        });
    },
    login: () => {
        clearTemplate();
        mainContainer.html($('#view_login').html());
        mainContainer.on('click', '.js_login', function (e) {
            e.preventDefault();
            localStorage.removeItem('token');
            $.ajax({
                url: routes.auth_login,
                method: 'POST',
                dataType: 'json',
                data: {
                    email: mainContainer.find('input[name=email]').val(),
                    password: mainContainer.find('input[name=password]').val(),
                },
                success: (data) => {
                    localStorage.setItem('user', JSON.stringify(data.user));
                    localStorage.setItem('token', data.token);
                    show.profile();
                },
                error: (data) => {
                    show.login();
                },
            });
        });
        mainContainer.on('click', '.js_register', function (e) {
            e.preventDefault();
            show.register();
        });
        mainContainer.show();
    },
    logout: () => {
        clearTemplate();
        localStorage.removeItem('user');
        localStorage.removeItem('token');
        show.login();
    },
    profile: () => {
        clearTemplate();
        $.ajax({
            url: routes.auth_getAuthenticatedUser,
            method: 'GET',
            dataType: 'json',
            data: {
            },
            success: (data) => {
                mainContainer.html($('#view_profile').html());
                localStorage.setItem('user', JSON.stringify(data.user));
                let user = JSON.parse(localStorage.getItem('user'));

                mainContainer.find('.js_first_name').html(user.first_name);
                mainContainer.find('.js_last_name').html(user.last_name);
                mainContainer.find('.js_email').html(user.email);

                mainContainer.on('click', '.js_logout', function (e) {
                    e.preventDefault();
                    show.logout();
                });
                mainContainer.on('click', '.js_save_podcast', function (e) {
                    e.preventDefault();
                    $.ajax({
                        url: route('user.update', {user: user.id}),
                        method: 'PATCH',
                        dataType: 'json',
                        data: {
                            podcast_id: mainContainer.find('select[name=podcast_id]').val(),
                        },
                        success: (data) => {
                            localStorage.setItem('user', JSON.stringify(data.user));
                            show.profile();
                        },
                        error: (data) => {
                            show.login();
                        },
                    });
                });

                if (user.podcast_id) {
                    $.ajax(route('podcast.show', {podcast: user.podcast_id}).toString()).done((podcast_show_data) => {
                        mainContainer.find('.js_podcast').html(podcast_show_data.podcast.name);
                        mainContainer.find('.js_if_podcast_present').show();
                    });
                } else {
                    mainContainer.find('.js_if_podcast_empty').show();
                }

                $.when( $.ajax(routes.podcast_index) ).done(function( podcast_index_data ) {
                    for (var i = 0 ; i < podcast_index_data.list.length ; i++) {
                        mainContainer.find('select[name=podcast_id]').append(`
                    <option value="${podcast_index_data.list[i].id}">${podcast_index_data.list[i].name}</option>
                `);
                    }
                    mainContainer.show();
                });

                mainContainer.show();
            }
        });
    }
}