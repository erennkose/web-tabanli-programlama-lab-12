<!DOCTYPE html>
<html>
<head>
    <title>URL Kısaltıcı</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <div style="text-align:center;margin-top:50px;">
        <h1>URL Kısaltıcı</h1>
        <input type="text" id="original_url" placeholder="URL Girin" style="width:300px;padding:10px;">
        <button onclick="shortenUrl()" style="padding:10px;">Kısalt</button>
        <p id="result"></p>
    </div>

    <script>
        function shortenUrl() {
            var originalUrl = $('#original_url').val();
            $.ajax({
                url: '/shorten',
                type: 'POST',
                data: {
                    original_url: originalUrl,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#result').text('Kısa URL: ' + response.short_url);
                },
                error: function(xhr) {
                    alert('Invalid URL');
                }
            });
        }
    </script>
</body>
</html>
