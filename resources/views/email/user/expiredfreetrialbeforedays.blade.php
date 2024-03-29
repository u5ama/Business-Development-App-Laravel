<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html>
<head>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i');
        .netblaze_email {
            background: #edf1f5;
            font-family: 'Open Sans', sans-serif;
            color: #6a6a6a;
            padding:50px;
        }
        .netblaze_header {
            max-width: 650px;
            margin: 35px auto auto;
            text-align: center;
        }
        .netblaze_footer {
            max-width: 650px;
            margin: auto;
            text-align: center;
            font-size: 14px;
            color: #787878
        }
        .netblaze_footer ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }
        .netblaze_footer ul li {
            display: inline-block;
        }
        .netblaze_footer ul.netblaze_footer_links li {
            border-right: 1px solid #626262;
        }
        .netblaze_footer ul.netblaze_footer_links li a {
            text-decoration: none;
            color: #626262;
            margin: 10px;
        }
        .netblaze_email_body {
            max-width: 650px;
            margin: 23px auto auto;
            background: #fff;
            padding: 50px 46px;
            box-sizing: border-box;
        }
        .netblaze_action_btn {
            text-align: center;
        }
        .netblaze_action_btn a {
            background: #232323;
            display: inline-block;
            color: #fff;
            text-decoration: none;
            padding: 10px 51px;
            font-size: 18px;
            margin: 20px 0;
        }
        .app_download_banner {
            margin-bottom:20px;
        }
        .social_media_icons {
            margin-bottom:20px;
        }
    </style>
</head>
<body>
<div style="padding: 50px; background-color: #edf1f5; font-family: 'Open Sans', sans-serif; color: #6a6a6a;">
    <div style="max-width: 650px; text-align: center; margin: 35px auto auto;" align="center">
        <img title="" alt="" src="http://34.237.166.80/public_images/netblaze-logo.png">
    </div>
    <div style="max-width: 650px; background-color: #fff; box-sizing: border-box; margin: 23px auto auto; padding: 50px 46px;">

        Hi {{$name}},
        <br/>
        <p>Your free trial will expire in {{ $days }} {{ $string }}. Upgrade your subscription now to keep enjoying all the benefits that come with your <?php echo getDomainName(); ?> subscription. To upgrade, just login to <a href="{{ $domain }}"> <?php echo getDomainName(); ?></a> and click on the “Upgrade” button</p>
        <p>Regards,
            <br/>Customer Support - <a href="mailto:support@netblaze.com" target="_top">support@nichepractice.com</a>
            <br/>Contact us by phone - 800-882-6131
            <br/>Follow us on <a href="https://www.facebook.com/netblazellc/">Facebook</a></p>
    </div>
    <div style="max-width: 650px; text-align: center; font-size: 14px; color: #787878; margin: auto;" align="center">
        <div style="margin-bottom: 20px;">
            <ul style="list-style-type: none; margin: 15px 0 0; padding: 0;">

                <li style="display: inline-block;"><a href="https://www.facebook.com/netblazellc/"><img title="facebook" alt="facebook" src="http://34.237.166.80/public_images/facebook-icon.png"></a></li>
                <li style="display: inline-block;"><a href="https://www.instagram.com/netblazellc/"><img title="instagram" alt="instagram" src="http://34.237.166.80/public_images/instagram-icon.png"></a></li>
                <li style="display: inline-block;"><a href="https://www.youtube.com/channel/UCB6ntTp2fRu22wSxGydmcAQ"><img title="youtube" alt="youtube" src="http://34.237.166.80/public_images/youtube-icon.png"></a></li>

            </ul>
        </div>

        {{--<p>605 N. Michigan Ave Suite 404 Chicago, IL 60611</p>--}}
        <p>Copyright 2019 <?php echo getDomainName(); ?> </p>
    </div>
</div>
</body>
</html>
