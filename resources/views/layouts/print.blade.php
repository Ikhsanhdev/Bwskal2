<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>
    @if (isset($title)) {{ $title }} | @else @yield('title', '') @endif @if (isset($titleOnly) && $titleOnly) @else {{ config('app.name') }} @endif
  </title>
  
  @if (isset($isMpdf) && $isMpdf === true)
  <link rel="stylesheet" href="assets/css/print.css">
  @else
  <link rel="stylesheet" href="{{ mix('assets/css/print.css') }}">
  @endif
  
  @yield('cssAfterMain')
  <script>
  function ready(callbackFunc) {
    if (document.readyState !== 'loading') {
      callbackFunc();
    } else if (document.addEventListener) {
      document.addEventListener('DOMContentLoaded', callbackFunc);
    } else {
      document.attachEvent('onreadystatechange', function() {
        if (document.readyState === 'complete') {
          callbackFunc();
        }
      });
    }
  }
  </script>
</head>
<body>
  @yield('content')
  
  @if (!isset($isMpdf) || (isset($isMpdf) && $isMpdf === false))
  @yield('script')
  @endif
</body>
</html>