<script>
    window.states = {
        routes: {
            'user.register.validate': "{{ route('user.register.validate') }}",
            'user.login.validate': "{{ route('user.login.validate') }}",
            'register': "{{ route('register') }}",
            'login': "{{ route('login') }}",
        }
    }
</script>

<script defer>
    function addToCart(id) {
        event.preventDefault();
        @if (Auth::check())
            let x = {
            id: id
            }
            fetch('/cart/store', {
            headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            body: JSON.stringify(x),
            method: 'post',
            }).then(function(response) {
            Notiflix.Confirm.show('Yippee!', 'Product added to the cart!' , 'Go To Cart', 'Stay', function(){
            location.href = "{{ route('cart') }}";
            }, function(){
            location.reload();
            });
            }).catch(function(error) {
            console.error('Error:', error);
            Notiflix.Notify.error('Product couldn\'t be added to the cart!');
            });
        @else
            UIkit.modal($("#signin-form").get(0)).show();
        @endif
    }

    function buyNow(id) {
        @if (Auth::check())
            location.href = "{{ route('checkout_buynow', '') }}/"+id;
        @else
            UIkit.modal($("#signin-form").get(0)).show();
        @endif
    }
</script>
