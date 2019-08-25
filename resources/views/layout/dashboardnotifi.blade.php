<header class="header black-bg">
  <div class="sidebar-toggle-box">
    <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
  </div>
  <a href="/" class="logo"><b>TNCITGROUP-<span>MS</span></b></a>

  <div class="nav notify-row" class="top-menu">

          <!--  notification start -->
          <ul class="nav top-menu">

              <!-- notification dropdown start-->
              {{--<li class="dropdown dropdown-notifications">
                  <a href="#notifications-panel" data-toggle="dropdown" class="dropdown-toggle">
                      <i data-count="0" class="fa fa-bell-o"></i>
                      <span class="badge bg-warning"><span class="notif-count">0</span></span>
                  </a>
                  <ul class="dropdown-menu extended notification">
                      <div class="notify-arrow notify-arrow-yellow"></div>
                      <li>
                          <p class="yellow dropdown-toolbar-title">You have <span class="notif-count">0</span> new notifications</p>
                      </li>
                      <ul class="dropdown-menu ">
                      </ul>
                      <li>
                          <a href="index.html#">
                              <span class="label label-danger"><i class="fa fa-bolt"></i></span>
                              Server Overloaded.
                              <span class="small italic">4 mins.</span>
                          </a>
                      </li>

                      <li>
                          --}}{{--<a href="index.html#">See all notifications</a>--}}{{--
                          <div class="dropdown-footer text-center">
                              <a href="#">See all notifications</a>
                          </div>
                      </li>
                  </ul>
              </li>--}}
              <!-- notification dropdown end -->
          </ul>
          <!--  notification end -->
  </div>

    <div class="top-menu">
    <ul class="nav pull-right top-menu">
      <li><a class="logout" href="{{ route('logout') }}"
        onclick="event.preventDefault();
        document.getElementById('logout-form').submit();">Logout</a></li>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          {{ csrf_field() }}
        </form>
      </ul>
    </div>
  </header>

<script src="//js.pusher.com/3.1/pusher.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<script type="text/javascript">
    var notificationsWrapper   = $('.dropdown-notifications');
    var notificationsToggle    = notificationsWrapper.find('a[data-toggle]');
    var notificationsCountElem = notificationsToggle.find('i[data-count]');
    var notificationsCount     = parseInt(notificationsCountElem.data('count'));
    var notifications          = notificationsWrapper.find('ul.dropdown-menu');

    if (notificationsCount <= 0) {
        notificationsWrapper.hide();
    }

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('72917c8348ebc8677084', {
        cluster: 'ap1',
        encrypted: true
    });

    // Subscribe to the channel we specified in our Laravel Event
    var channel = pusher.subscribe('status-liked');

    // Bind a function to a Event (the full Laravel class)
    channel.bind('App\\Events\\StatusLiked', function(data) {
        var existingNotifications = notifications.html();
        var avatar = Math.floor(Math.random() * (71 - 20 + 1)) + 20;
        var newNotificationHtml = `
          <li class="notification active">
              <div class="media">
                <div class="media-left">
                  <div class="media-object">
                    <img src="https://api.adorable.io/avatars/71/`+avatar+`.png" class="img-circle" alt="50x50" style="width: 50px; height: 50px;">
                  </div>
                </div>
                <div class="media-body">
                  <strong class="notification-title">`+data.message+`</strong>
                  <!--p class="notification-desc">Extra description can go here</p-->
                  <div class="notification-meta">
                    <small class="timestamp">about a minute ago</small>
                  </div>
                </div>
              </div>
          </li>
        `;
        notifications.html(newNotificationHtml + existingNotifications);

        notificationsCount += 1;
        notificationsCountElem.attr('data-count', notificationsCount);
        notificationsWrapper.find('.notif-count').text(notificationsCount);
        notificationsWrapper.show();
    });
</script>
