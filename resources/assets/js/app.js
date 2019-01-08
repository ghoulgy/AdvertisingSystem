
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example', require('./components/Example.vue'));
Vue.component('chat-message', require('./components/ChatMessage.vue'));
Vue.component('chat-log', require('./components/ChatLog.vue'));
Vue.component('chat-composer', require('./components/ChatComposer.vue'));
Vue.component('noti', require('./components/noti.vue'));
Vue.component('g-map', require('./components/G-map.vue'));
Vue.component('noti', require('./components/notification'));

const app =
    document.addEventListener('DOMContentLoaded', function() {
        new Vue({
            el: '#app',

            mounted() {
                console.log("mounted");
            },

            created() {
                axios.get('/messages').then(response => {
                    this.messages = response.data;
                    console.log(response.data);            
                    Echo.channel('chatroom')
                    .listen('.PublicChatroom', (e) => {
                        this.messages.push({
                            message: e.message.message,
                            user: e.user
                        });
                        // console.log(e.message);
                    });
                })
            },

            data: {
            	messages: [],
            	usersInRoom: []
            },

            methods: {
            	addMessage(message) {
            		this.messages.push(message);
            		axios.post('/messages', message).then(response => {
            			console.log(response);
            		})
            	}
            }
        });
    });