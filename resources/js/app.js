
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');


// passport

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue')
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue')
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue')
);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('file-simple-uploader', require('./components/FileUploader.vue'));
Vue.component('photo-gallery', require('./components/PhotoGallery.vue'));
Vue.component('image-uploader', require('./components/ImageUploader.vue'));
Vue.component('map-pointer', require('./components/MapPointer.vue'));
Vue.component('follow-panel', require('./components/FollowPanel.vue'));
Vue.component('fav-panel', require('./components/FavPanel.vue'));
Vue.component('user-panel', require('./components/UserPanel.vue'));
Vue.component('home-panel', require('./views/HomePanel.vue'));
Vue.component('comment-panel', require('./components/CommentPanel.vue'));

import router from './router'
import store from './store'

const app = new Vue({
    router,
    store,
}).$mount('#app');

// service worker
window.addEventListener('load', () => {
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/sw.js').
        then(() => {
            console.log('ServiceWorker registered')
        }).
        catch((error) => {
            console.warn('ServiceWorker error', error)
        })
    }
})

// jquery

import 'jquery-ui/ui/widgets/dialog.js';

$(function() {
    $(".confirm-form").on('submit', function(e, context) {
        var form=$(this);
        if ($(this).attr('gate') == 'open'){
            $(this).attr('gate','close');
            return true;
        }
        e.preventDefault();
        $("#dialog-msg").dialog({
            modal:true, //モーダル表示
            title:"確認", //タイトル
            buttons: { //ボタン
                "確認": function() {
                    $(this).dialog("close");
                    form.attr("gate","open");
                    form.submit();
                },
                "キャンセル": function() {
                    $(this).dialog("close");
                }
            }
        });
    });
});

