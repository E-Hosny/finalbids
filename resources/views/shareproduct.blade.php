<!DOCTYPE html>
<html>
<head>
    <title>Product</title>
</head>
<body>
  

    <script>
        function checkAppAndRedirect() {
            // Define the deep link URL
            let playStoreLink ='';
            const userAgent = navigator.userAgent;
            if (userAgent.match(/Android/i)) {
                const deepLink = 'ewill://product/' + promoId + '/' + promoType;
                 playStoreLink = 'https://play.google.com/store/apps/details?id=ewill';
                window.location.href = deepLink;
            } else if (userAgent.match(/iPhone|iPad|iPod/i)) {
                const deepLink = 'ewill://product/' + promoId + '/' + promoType;
                playStoreLink = 'https://apps.apple.com/app/idYourAppID';
                window.location.href = deepLink;
            }
            setTimeout(function() {
                window.location.href = playStoreLink;
            }, 1000); 

        }

        checkAppAndRedirect();
    </script>
</body>
</html>
<!-- <script>
        function checkAppAndRedirect() {
            const promoId = <?php echo json_encode($promo_id); ?>;
            const promoType = <?php echo json_encode($promo_type); ?>;
            const userAgent = navigator.userAgent;
            let deepLink, appStoreLink;

            if (userAgent.match(/Android/i)) {
                deepLink = 'ewill://product/' + promoId + '/' + promoType;
                appStoreLink = 'https://play.google.com/store/apps/details?id=ewill';
            } else if (userAgent.match(/iPhone|iPad|iPod/i)) {
                deepLink = 'ewill://product/' + promoId + '/' + promoType;
                appStoreLink = 'https://apps.apple.com/app/idYourAppID';
            }

           
            if (deepLink) {
                window.location.href = deepLink;
            } else {
                window.location.href = appStoreLink;
            }
        }

        checkAppAndRedirect();
    </script> -->

