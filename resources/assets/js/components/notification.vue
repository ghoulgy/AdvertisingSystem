<template>
  <ul class="nav navbar-nav">
    <li class="dropdown dropdown-notifications">
      <a href="#notifications-panel" class="dropdown-toggle" data-toggle="dropdown">
        <i data-count="0" id="noti-count" class="glyphicon glyphicon-bell notification-icon"></i>
      </a>

      <div class="dropdown-container">
        <div class="dropdown-toolbar">
          <div class="dropdown-toolbar-actions">
            <a href="#">Mark all as read</a>
          </div>
          <h3 class="dropdown-toolbar-title">Notifications (<span>{{ notificationsCount }}</span>)</h3>
        </div>
        <ul class="dropdown-menu"></ul>
        <div class="dropdown-footer text-center">
          <a href="#">View All</a>
        </div>
      </div>
    </li>
  </ul>
</template>

<script>
  
  export default {
    data() {
      return {
        notificationsCount: 0,
      }
    },

    created() {
      // axios.get('/').then(response => {

      // })
      Echo.channel('pubNoti')
      .listen('.PublicNotification', noti => {
        let notificationsWrapper = $('.dropdown-notifications');
        let notificationsToggle = notificationsWrapper.find('a[data-toggle]');
        let notificationsCountElem = notificationsToggle.find('i[data-count]');
        let notificationsCount = parseInt(notificationsCountElem.data('count'));
        let notifications = notificationsWrapper.find('ul.dropdown-menu');
        let existingNotifications = notifications.html();
        let avatar = Math.floor(Math.random() * (71 - 20 + 1)) + 20;
        let newNotificationHtml = `
          <li class="notification active">
              <div class="media">
                <div class="media-left">
                  <div class="media-object">
                    <img src="https://api.adorable.io/avatars/71/`+avatar+`.png" class="img-circle" alt="50x50" style="width: 50px; height: 50px;">
                  </div>
                </div>
                <div class="media-body">
                  <strong class="notification-title">`+noti.message+`</strong>
                  <!--p class="notification-desc">Extra description can go here</p-->
                  <div class="notification-meta">
                    <small class="timestamp">about a minute ago</small>
                  </div>
                </div>
              </div>
          </li>
        `;
        notifications.html(newNotificationHtml + existingNotifications);
        let currentNotiCount = this.notificationsCount += 1;
        notificationsCountElem.attr('data-count', currentNotiCount);
      });
    },
  }
</script>