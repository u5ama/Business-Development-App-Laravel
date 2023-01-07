{{-- <div style="border-radius: 45px; background-color:#D1DCE4;text-align: center !important;padding-top: 3rem!important;padding-bottom: 3rem!important;"> --}}
    <div style="text-align: center !important;background-color: #fff !important;margin-top: 1.5rem!important;margin-bottom: 1.5rem!important;">
        <div id="mobile_top_background_color" style="display: flex;flex-wrap: wrap;background-color:{{$top_background_color}}; ">
            <div style="flex: 0 0 41.666667%;max-width: 41.666667%;position: relative;width: 100%;min-height: 1px;padding-right: 15px;padding-left: 15px;box-sizing: border-box;">
                @if ($logo_image_src)
                    <img id="mobile_logo_image_src" src="{{ asset('public/storage/'.$logo_image_src) }}" alt="" style="max-width: 100%;height: auto; max-height:100px; padding: .25rem!important;">
                @else
                    <img id="mobile_logo_image_src" src="{{ asset('public/images/default-logo.png') }}" alt="" style="max-width: 100%;height: auto; max-height:100px; padding: .25rem!important;">
                @endif
                
            </div>
            <div style="flex: 0 0 58.333333%;max-width: 58.333333%;position: relative;width: 100%;min-height: 1px;padding-right: 15px;padding-left: 15px;box-sizing: border-box;display: flex !important;align-items: center!important;justify-content: flex-end!important;">
                <p style="text-align: right !important;margin-bottom: 0!important;padding-left: .5rem!important;padding-right: .5rem!important;">
                    @if ($review_number_color)
                    <span id="mobile_review_number_color" style="padding-left: .5rem!important;padding-right: .5rem!important;font-weight: 600 !important;font-size: 14px; color:{{$review_number_color}};">5.0</span>
                        
                    @else
                    <span id="mobile_review_number_color" style="padding-left: .5rem!important;padding-right: .5rem!important;font-weight: 600 !important;font-size: 14px; color:#D2D2D2;">N/A</span>
                        
                    @endif
                    @if ($star_rating_color)
                        <span>
                            <svg height="14px" viewBox="0 -10 511.98685 511" width="14px" xmlns="http://www.w3.org/2000/svg"><path d="m510.652344 185.902344c-3.351563-10.367188-12.546875-17.730469-23.425782-18.710938l-147.773437-13.417968-58.433594-136.769532c-4.308593-10.023437-14.121093-16.511718-25.023437-16.511718s-20.714844 6.488281-25.023438 16.535156l-58.433594 136.746094-147.796874 13.417968c-10.859376 1.003906-20.03125 8.34375-23.402344 18.710938-3.371094 10.367187-.257813 21.738281 7.957031 28.90625l111.699219 97.960937-32.9375 145.089844c-2.410156 10.667969 1.730468 21.695313 10.582031 28.09375 4.757813 3.4375 10.324219 5.1875 15.9375 5.1875 4.839844 0 9.640625-1.304687 13.949219-3.882813l127.46875-76.183593 127.421875 76.183593c9.324219 5.609376 21.078125 5.097657 29.910156-1.304687 8.855469-6.417969 12.992187-17.449219 10.582031-28.09375l-32.9375-145.089844 111.699219-97.941406c8.214844-7.1875 11.351563-18.539063 7.980469-28.925781zm0 0" fill="{{$star_rating_color}}"/></svg>
                            <svg height="14px" viewBox="0 -10 511.98685 511" width="14px" xmlns="http://www.w3.org/2000/svg"><path d="m510.652344 185.902344c-3.351563-10.367188-12.546875-17.730469-23.425782-18.710938l-147.773437-13.417968-58.433594-136.769532c-4.308593-10.023437-14.121093-16.511718-25.023437-16.511718s-20.714844 6.488281-25.023438 16.535156l-58.433594 136.746094-147.796874 13.417968c-10.859376 1.003906-20.03125 8.34375-23.402344 18.710938-3.371094 10.367187-.257813 21.738281 7.957031 28.90625l111.699219 97.960937-32.9375 145.089844c-2.410156 10.667969 1.730468 21.695313 10.582031 28.09375 4.757813 3.4375 10.324219 5.1875 15.9375 5.1875 4.839844 0 9.640625-1.304687 13.949219-3.882813l127.46875-76.183593 127.421875 76.183593c9.324219 5.609376 21.078125 5.097657 29.910156-1.304687 8.855469-6.417969 12.992187-17.449219 10.582031-28.09375l-32.9375-145.089844 111.699219-97.941406c8.214844-7.1875 11.351563-18.539063 7.980469-28.925781zm0 0" fill="{{$star_rating_color}}"/></svg>
                            <svg height="14px" viewBox="0 -10 511.98685 511" width="14px" xmlns="http://www.w3.org/2000/svg"><path d="m510.652344 185.902344c-3.351563-10.367188-12.546875-17.730469-23.425782-18.710938l-147.773437-13.417968-58.433594-136.769532c-4.308593-10.023437-14.121093-16.511718-25.023437-16.511718s-20.714844 6.488281-25.023438 16.535156l-58.433594 136.746094-147.796874 13.417968c-10.859376 1.003906-20.03125 8.34375-23.402344 18.710938-3.371094 10.367187-.257813 21.738281 7.957031 28.90625l111.699219 97.960937-32.9375 145.089844c-2.410156 10.667969 1.730468 21.695313 10.582031 28.09375 4.757813 3.4375 10.324219 5.1875 15.9375 5.1875 4.839844 0 9.640625-1.304687 13.949219-3.882813l127.46875-76.183593 127.421875 76.183593c9.324219 5.609376 21.078125 5.097657 29.910156-1.304687 8.855469-6.417969 12.992187-17.449219 10.582031-28.09375l-32.9375-145.089844 111.699219-97.941406c8.214844-7.1875 11.351563-18.539063 7.980469-28.925781zm0 0" fill="{{$star_rating_color}}"/></svg>
                            <svg height="14px" viewBox="0 -10 511.98685 511" width="14px" xmlns="http://www.w3.org/2000/svg"><path d="m510.652344 185.902344c-3.351563-10.367188-12.546875-17.730469-23.425782-18.710938l-147.773437-13.417968-58.433594-136.769532c-4.308593-10.023437-14.121093-16.511718-25.023437-16.511718s-20.714844 6.488281-25.023438 16.535156l-58.433594 136.746094-147.796874 13.417968c-10.859376 1.003906-20.03125 8.34375-23.402344 18.710938-3.371094 10.367187-.257813 21.738281 7.957031 28.90625l111.699219 97.960937-32.9375 145.089844c-2.410156 10.667969 1.730468 21.695313 10.582031 28.09375 4.757813 3.4375 10.324219 5.1875 15.9375 5.1875 4.839844 0 9.640625-1.304687 13.949219-3.882813l127.46875-76.183593 127.421875 76.183593c9.324219 5.609376 21.078125 5.097657 29.910156-1.304687 8.855469-6.417969 12.992187-17.449219 10.582031-28.09375l-32.9375-145.089844 111.699219-97.941406c8.214844-7.1875 11.351563-18.539063 7.980469-28.925781zm0 0" fill="{{$star_rating_color}}"/></svg>
                            <svg height="14px" viewBox="0 -10 511.98685 511" width="14px" xmlns="http://www.w3.org/2000/svg"><path d="m510.652344 185.902344c-3.351563-10.367188-12.546875-17.730469-23.425782-18.710938l-147.773437-13.417968-58.433594-136.769532c-4.308593-10.023437-14.121093-16.511718-25.023437-16.511718s-20.714844 6.488281-25.023438 16.535156l-58.433594 136.746094-147.796874 13.417968c-10.859376 1.003906-20.03125 8.34375-23.402344 18.710938-3.371094 10.367187-.257813 21.738281 7.957031 28.90625l111.699219 97.960937-32.9375 145.089844c-2.410156 10.667969 1.730468 21.695313 10.582031 28.09375 4.757813 3.4375 10.324219 5.1875 15.9375 5.1875 4.839844 0 9.640625-1.304687 13.949219-3.882813l127.46875-76.183593 127.421875 76.183593c9.324219 5.609376 21.078125 5.097657 29.910156-1.304687 8.855469-6.417969 12.992187-17.449219 10.582031-28.09375l-32.9375-145.089844 111.699219-97.941406c8.214844-7.1875 11.351563-18.539063 7.980469-28.925781zm0 0" fill="{{$star_rating_color}}"/></svg>
                        </span>
                    @else
                        <span>
                            <svg height="14px" viewBox="0 -10 511.98685 511" width="14px" xmlns="http://www.w3.org/2000/svg"><path d="m510.652344 185.902344c-3.351563-10.367188-12.546875-17.730469-23.425782-18.710938l-147.773437-13.417968-58.433594-136.769532c-4.308593-10.023437-14.121093-16.511718-25.023437-16.511718s-20.714844 6.488281-25.023438 16.535156l-58.433594 136.746094-147.796874 13.417968c-10.859376 1.003906-20.03125 8.34375-23.402344 18.710938-3.371094 10.367187-.257813 21.738281 7.957031 28.90625l111.699219 97.960937-32.9375 145.089844c-2.410156 10.667969 1.730468 21.695313 10.582031 28.09375 4.757813 3.4375 10.324219 5.1875 15.9375 5.1875 4.839844 0 9.640625-1.304687 13.949219-3.882813l127.46875-76.183593 127.421875 76.183593c9.324219 5.609376 21.078125 5.097657 29.910156-1.304687 8.855469-6.417969 12.992187-17.449219 10.582031-28.09375l-32.9375-145.089844 111.699219-97.941406c8.214844-7.1875 11.351563-18.539063 7.980469-28.925781zm0 0" fill="#D2D2D2"/></svg>
                            <svg height="14px" viewBox="0 -10 511.98685 511" width="14px" xmlns="http://www.w3.org/2000/svg"><path d="m510.652344 185.902344c-3.351563-10.367188-12.546875-17.730469-23.425782-18.710938l-147.773437-13.417968-58.433594-136.769532c-4.308593-10.023437-14.121093-16.511718-25.023437-16.511718s-20.714844 6.488281-25.023438 16.535156l-58.433594 136.746094-147.796874 13.417968c-10.859376 1.003906-20.03125 8.34375-23.402344 18.710938-3.371094 10.367187-.257813 21.738281 7.957031 28.90625l111.699219 97.960937-32.9375 145.089844c-2.410156 10.667969 1.730468 21.695313 10.582031 28.09375 4.757813 3.4375 10.324219 5.1875 15.9375 5.1875 4.839844 0 9.640625-1.304687 13.949219-3.882813l127.46875-76.183593 127.421875 76.183593c9.324219 5.609376 21.078125 5.097657 29.910156-1.304687 8.855469-6.417969 12.992187-17.449219 10.582031-28.09375l-32.9375-145.089844 111.699219-97.941406c8.214844-7.1875 11.351563-18.539063 7.980469-28.925781zm0 0" fill="#D2D2D2"/></svg>
                            <svg height="14px" viewBox="0 -10 511.98685 511" width="14px" xmlns="http://www.w3.org/2000/svg"><path d="m510.652344 185.902344c-3.351563-10.367188-12.546875-17.730469-23.425782-18.710938l-147.773437-13.417968-58.433594-136.769532c-4.308593-10.023437-14.121093-16.511718-25.023437-16.511718s-20.714844 6.488281-25.023438 16.535156l-58.433594 136.746094-147.796874 13.417968c-10.859376 1.003906-20.03125 8.34375-23.402344 18.710938-3.371094 10.367187-.257813 21.738281 7.957031 28.90625l111.699219 97.960937-32.9375 145.089844c-2.410156 10.667969 1.730468 21.695313 10.582031 28.09375 4.757813 3.4375 10.324219 5.1875 15.9375 5.1875 4.839844 0 9.640625-1.304687 13.949219-3.882813l127.46875-76.183593 127.421875 76.183593c9.324219 5.609376 21.078125 5.097657 29.910156-1.304687 8.855469-6.417969 12.992187-17.449219 10.582031-28.09375l-32.9375-145.089844 111.699219-97.941406c8.214844-7.1875 11.351563-18.539063 7.980469-28.925781zm0 0" fill="#D2D2D2"/></svg>
                            <svg height="14px" viewBox="0 -10 511.98685 511" width="14px" xmlns="http://www.w3.org/2000/svg"><path d="m510.652344 185.902344c-3.351563-10.367188-12.546875-17.730469-23.425782-18.710938l-147.773437-13.417968-58.433594-136.769532c-4.308593-10.023437-14.121093-16.511718-25.023437-16.511718s-20.714844 6.488281-25.023438 16.535156l-58.433594 136.746094-147.796874 13.417968c-10.859376 1.003906-20.03125 8.34375-23.402344 18.710938-3.371094 10.367187-.257813 21.738281 7.957031 28.90625l111.699219 97.960937-32.9375 145.089844c-2.410156 10.667969 1.730468 21.695313 10.582031 28.09375 4.757813 3.4375 10.324219 5.1875 15.9375 5.1875 4.839844 0 9.640625-1.304687 13.949219-3.882813l127.46875-76.183593 127.421875 76.183593c9.324219 5.609376 21.078125 5.097657 29.910156-1.304687 8.855469-6.417969 12.992187-17.449219 10.582031-28.09375l-32.9375-145.089844 111.699219-97.941406c8.214844-7.1875 11.351563-18.539063 7.980469-28.925781zm0 0" fill="#D2D2D2"/></svg>
                            <svg height="14px" viewBox="0 -10 511.98685 511" width="14px" xmlns="http://www.w3.org/2000/svg"><path d="m510.652344 185.902344c-3.351563-10.367188-12.546875-17.730469-23.425782-18.710938l-147.773437-13.417968-58.433594-136.769532c-4.308593-10.023437-14.121093-16.511718-25.023437-16.511718s-20.714844 6.488281-25.023438 16.535156l-58.433594 136.746094-147.796874 13.417968c-10.859376 1.003906-20.03125 8.34375-23.402344 18.710938-3.371094 10.367187-.257813 21.738281 7.957031 28.90625l111.699219 97.960937-32.9375 145.089844c-2.410156 10.667969 1.730468 21.695313 10.582031 28.09375 4.757813 3.4375 10.324219 5.1875 15.9375 5.1875 4.839844 0 9.640625-1.304687 13.949219-3.882813l127.46875-76.183593 127.421875 76.183593c9.324219 5.609376 21.078125 5.097657 29.910156-1.304687 8.855469-6.417969 12.992187-17.449219 10.582031-28.09375l-32.9375-145.089844 111.699219-97.941406c8.214844-7.1875 11.351563-18.539063 7.980469-28.925781zm0 0" fill="#D2D2D2"/></svg>
                        </span>
                    @endif
                    
                </p>
            
                
            </div>
        </div>
        {{-- <hr class="mx-3 my-1"> --}}
        
        @if ($background_image_src)
        <div id="mobile-background_image_src" style="padding-left: 1rem!important;padding-right: 1rem!important;background-image: url('{{config('app.url')."public/storage/".$background_image_src}}')">
            
        @else
        <div id="mobile-background_image_src" style="padding-left: 1rem!important;padding-right: 1rem!important;">
            
        @endif
            <div style="max-height: 115px; overflow: hidden;padding-top: 3rem!important;">
                @if ($email_heading)
                <h1 id="mobile_email_heading">{{$email_heading}} </h1>
                    
                @else
                <h1 id="mobile_email_heading">Would you be so kind to recommend us?</h1>
                    
                @endif
            </div>
            <div style="max-height: 130px; overflow: hidden;padding-top: 1.5rem!important;">
                @if ($email_message)
                <p id="mobile_email_message" style="font-weight: 600 !important;">{{$email_message}}</p>
                    
                @else
                <p id="mobile_email_message" style="font-weight: 600 !important;">Hi there! <br>
                    Thanks for choosing {{$BusinessName}}. If you have a few minutes, I'd like to invite you to tell us about your experience. Your feedback is very important to us and it would be awesome if you can share it with us and our potential customers.</p>
                    
                @endif
            </div>
            <div style="padding-top: 1.5rem!important;">
                <a href="{{ url('business-review/'.$email.'/'.$varificationCode.'/'.$businessId.'/'.$reviewId.'/positive') }}" style="
                    position: relative;
                    transition: all .15s ease;
                    letter-spacing: .025em;
                    text-transform: none;
                    will-change: transform;
                    background-color: #00cf00;
                    color: #fff;
                    box-shadow: none;
                    display: block;
                    width: 100%;
                    font-size: 1rem;
                    font-weight: 600;
                    line-height: 1.5;
                    padding: .625rem 1.25rem;
                    -webkit-user-select: none;
                    -moz-user-select: none;
                    -ms-user-select: none;
                    user-select: none;
                    transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
                    text-align: center;
                    vertical-align: middle;
                    white-space: nowrap;
                    border: 1px solid transparent;
                    border-radius: .375rem;
                    
                    background-color: #00cf00;
                    color: #fff;
                    box-shadow: none;

                    margin-bottom: 1rem!important;

                    border-radius: 0 !important;
                    outline: none !important;
                    max-width:200px;
                    margin:auto;
                ">
                    @if ($email_positive_anwser)
                    <span id="mobile_email_positive_anwser">{{$email_positive_anwser}}</span>
                    
                    @else
                    <span id="mobile_email_positive_anwser">Yes</span>
                    @endif
            </a>
        <a href="{{ url('business-review/'.$email.'/'.$varificationCode.'/'.$businessId.'/'.$reviewId.'/negative') }}" style="
                    position: relative;
                    transition: all .15s ease;
                    letter-spacing: .025em;
                    text-transform: none;
                    will-change: transform;
                    background-color: #00cf00;
                    color: #fff;
                    box-shadow: none;
                    display: block;
                    width: 100%;
                    font-size: 1rem;
                    font-weight: 600;
                    line-height: 1.5;
                    padding: .625rem 1.25rem;
                    -webkit-user-select: none;
                    -moz-user-select: none;
                    -ms-user-select: none;
                    user-select: none;
                    transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
                    text-align: center;
                    vertical-align: middle;
                    white-space: nowrap;
                    border: 1px solid transparent;
                    border-radius: .375rem;
                    
                    background-color: #00cf00;
                    color: #fff;
                    box-shadow: none;

                    margin-bottom: 1rem!important;

                    border-radius: 0 !important;
                    background-color: #F1F7FA;
                    color: #212529 !important;
                    border: 0 !important;
                    outline: none !important;
                    max-width:200px;
                    margin:auto;
                    ">
                    @if ($email_negative_anwser)
                    <span id="mobile_email_negative_anwser">{{$email_negative_anwser}}</span>
                        
                    @else
                    <span id="mobile_email_negative_anwser">No, Thanks</span>
                        
                    @endif
        </a>
            </div>
            <div style="padding-top: 1.5rem!important;padding-bottom: 3rem!important;">
                <p style="font-weight: 600 !important;">Sincerely,</p>
                <p style="font-weight: 600 !important;">
                    @if ($full_name)
                        <span id="mobile_full_name">{{$full_name}}</span>,
                    @else
                        <span id="mobile_full_name">{{$firstName}}</span>,
                    @endif
                    @if ($company_role)
                        <span id="mobile_company_role">{{$company_role}}</span>
                    @else
                        <span id="mobile_company_role">Business Manager</span>
                    @endif
                </p>
                <div>
                    @if ($personal_avatar_src)
                        <img id="mobile_personal_avatar_src" src="{{ asset('public/storage/'.$personal_avatar_src) }}" alt="" style="max-width: 100%;height: auto; max-height: 50px;border-radius: 50% !important;">
                    @else
                        <img id="mobile_personal_avatar_src" src="{{ asset('public/images/avatardp.png') }}" alt="" style="max-width: 100%;height: auto; max-height: 50px;border-radius: 50% !important;">
                    @endif
                </div>
            </div>
        </div>
        
    </div>
{{-- </div> --}}