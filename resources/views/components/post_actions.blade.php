<script>
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function () {

        $('#browse-click').on('click', function () { // use .live() for older versions of jQuery
            $('#imgInp').click();
            //setInterval(intervalFunc, 1);
            return false;
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    console.log(e)
                    console.log(e.target.result)
                    var html = '<span class="btn" id="imgClear">&times</span> <img src="' + e.target.result + '" id="imgPreview" height="200px">'
                    // $('#imgPreview').attr('src', e.target.result);
                    $('#imgPreviewContainer').html(html)
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#imgInp").change(function () {
            console.log("readURL(this)")
            readURL(this);
        });

    });

    $("#imgPreviewContainer").on('click', '#imgClear', function () {
        $("#imgInp").val('')
        $('#imgPreviewContainer').html('')
    })

    function show_comments(id) {
        console.log('#comment-list-' + id)
        if ($('#comment-list-' + id).hasClass('display-none'))
            $('#comment-list-' + id).removeClass('display-none')
        else {
            $('#comment-list-' + id).addClass('display-none')
        }
    }

    function add_comment(id) {
        var inp_id = '#inputComment-' + id

        if ($(inp_id).val() == '') {
            $(inp_id).attr('placeholder', 'Write a comment here')
        } else {
            $.ajax({
                url: app_url + '/add-comment',
                method: "POST",
                dataType: 'json',
                data: {_token: CSRF_TOKEN, comment: $(inp_id).val(), id: id},
                success: function (data) {
                    if (data.status === "success") {

                        comment_html =
                            `<div class="col-lg-1 col-2 px-2">
                                    <div class="img-square">
                                        <a href="{{ url('profile/'.auth()->user()->username) }}">
                                        <img
                                        class="rounded-circle object-fit-cover border img-fluid"
                                        src="{{auth()->user()->profile_image == null ? asset('assets/images/icon/user.png') : url('uploads/'.auth()->user()->profile_image)}}"
                                        >
                                            </a>
                                    </div>
                                    </div>
                                    <div class="col-lg-11 col-10 px-2 pt-1">
                                    <a href="{{ url('profile/'.auth()->user()->username) }}">{{auth()->user()->username}}</a>`
                            + $(inp_id).val() +
                            `</div>`

                        html = $('.comment_rows').html();
                        html += comment_html;
                        $('.comment_rows').html(html)
                        $(inp_id).val('')
                    }
                }
            })
        }
    }

    function like(id) {

        $.ajax({
            url: app_url + '/like/' + id,
            method: "GET",
            success: function (data) {
                console.log(data)
                if (data.hasOwnProperty('liked')) {
                    var btn_id = '#like-' + id + ' > .like-btn'
                    if (data.liked == 1) {
                        $(btn_id).addClass('fas')
                        $(btn_id).removeClass('far')
                        let count = $('#like-' + id).next('.likes-count').html()
                        count = parseInt(count) + 1
                        $('#like-' + id).next('.likes-count').html(count)
                    } else {
                        $(btn_id).addClass('far')
                        $(btn_id).removeClass('fas')
                        let count = $('#like-' + id).next('.likes-count').html()
                        count = parseInt(count) - 1
                        $('#like-' + id).next('.likes-count').html(count)
                    }
                }
            }
        })

    }


</script>
