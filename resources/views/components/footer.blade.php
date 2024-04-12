<x-links></x-links>
<footer class="py-4 mt-auto" style="background: #0080ffb1;">
    <div class="container">
        <div class="row">
            <div class="col"></div>
            <div class="col-2 mb-3 w-75">
                <h5 class="text-white">Подпишитесь на рассылку</h5>
                <form class="w-100%" action="/mailing_validation" method="POST">
                    @csrf
                    <div class="input-group">
                        <input type="email" class="form-control" placeholder="Введите ваш email" aria-label="Введите ваш email" aria-describedby="button-addon2" name="email">
                        <button type="submit" class="btn btn-primary" type="button" id="button-addon2">Подписаться</button>
                    </div>
                    @error('email')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </form>
            </div>
            <div class="col"></div>
        </div>
    </div>
</footer>
<x-scripts></x-scripts>
</body>
</html>
