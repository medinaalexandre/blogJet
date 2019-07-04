//require('./bootstrap');

<script type="text/javascript">
    // like post
    $(function(){
        $('.likePost').submit(function(e){
            e.preventDefault();
            var route = '/likePost';
            var form_data = $(this);

            $.ajax({
                type: 'POST',
                url: route,
                data: form_data.serialize(),
                success: function(){
                    troca();
                },
            });

            function troca(){
                let icon = e.target.getElementsByName('likesIconPost');
                let nr = e.target.getElementsByClassName('likesCountPost');
                if(icon[0].classList.contains('far')){
                    nr[0].innerHTML++;
                    icon[0].classList.remove('far');
                    icon[0].classList.add('fas');
                }else{
                    nr[0].innerHTML--;
                    icon[0].classList.add('far');
                    icon[0].classList.remove('fas');
                }
            }

        });
    });

$(function(){
    $('.likeComment').submit(function(e){
        e.preventDefault();
        var route = '/likeComment';
        var form_data = $(this);

        $.ajax({
            type: 'POST',
            url: route,
            data: form_data.serialize(),
            success: function(){
                troca();
            },
        });
        function troca(){
            let icon = e.target.getElementsByClassName('likesIcon');
            let nr = e.target.getElementsByClassName('likesCount');
            if(icon[0].classList.contains('far')){
                nr[0].innerHTML++;
                icon[0].classList.remove('far');
                icon[0].classList.add('fas');
            }else{
                nr[0].innerHTML--;
                icon[0].classList.add('far');
                icon[0].classList.remove('fas');
            }
        }
    });
});
</script>