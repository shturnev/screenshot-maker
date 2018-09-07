<?php
require_once "blocks/Auth.php";

if ($_COOKIE['token'] != $auth['token']) {
    require_once "blocks/login.php";
    exit;
}

?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="utf-8"/>
  <title>Screenshot-maker</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.4.3/css/foundation.min.css"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <style>
    .pointer{
      cursor: pointer;}

    .loader-cont{
      display: flex;
      justify-content: center;
      align-items: center;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.6);
      z-index: 2;
    }
    .loader,
    .loader:before,
    .loader,
    .loader:before,
    .loader:after {
      background: #ffffff;
      -webkit-animation: load1 1s infinite ease-in-out;
      animation: load1 1s infinite ease-in-out;
      width: 1em;
      height: 4em;
    }
    .loader {
      color: #ffffff;
      text-indent: -9999em;
      margin: 88px auto;
      position: relative;
      font-size: 11px;
      -webkit-transform: translateZ(0);
      -ms-transform: translateZ(0);
      transform: translateZ(0);
      -webkit-animation-delay: -0.16s;
      animation-delay: -0.16s;
    }
    .loader:before,
    .loader:after {
      position: absolute;
      top: 0;
      content: '';
    }
    .loader:before {
      left: -1.5em;
      -webkit-animation-delay: -0.32s;
      animation-delay: -0.32s;
    }
    .loader:after {
      left: 1.5em;
    }
    @-webkit-keyframes load1 {
      0%,
      80%,
      100% {
        box-shadow: 0 0;
        height: 4em;
      }
      40% {
        box-shadow: 0 -2em;
        height: 5em;
      }
    }
    @keyframes load1 {
      0%,
      80%,
      100% {
        box-shadow: 0 0;
        height: 4em;
      }
      40% {
        box-shadow: 0 -2em;
        height: 5em;
      }
    }

  </style>
</head>

<body>

<div class="grid-container" id="app">
  <div style="height: 50px;"></div>
  <h1>Hello to Screenshot-Maker!</h1>

  <div style="height: 80px;"></div>

  <div>
    <label>Сделать скриншот для url?</label>
    <div class="input-group">
      <input class="input-group-field" type="text" placeholder="https://work-timer.pro/"
             v-model="url_input" @keyup.enter="add_new_url">
      <div class="input-group-button">
        <input type="submit" class="button" value="Submit" @click="add_new_url">
      </div>
    </div>
  </div>
  <div style="height: 30px;"></div>
  <div class="grid-x grid-padding-x">
    <div class="cell medium-2" v-for="item in screens" :key="item.name">
      <div class="card" >
        <div class="card-divider">
          <h5>{{item.name}}</h5>
        </div>
        <img class="pointer" :src="'FILES/'+item.filename" @click="item.show = !item.show">
        <div class="card-section" v-show="item.show">
          <pre><code class="json"  v-html="JSON.stringify(item)"></code></pre>
        </div>
      </div>

    </div>
  </div>

  <div class="loader-cont" v-if="loader">
    <div class="loader"></div>
  </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/babel-standalone/6.26.0/babel.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.13/vue.min.js"></script>
<script>
  const app = new Vue({
    el: '#app',
    data() {
      return {
        screens: [],
        url_input: '',
        loader: false
      }
    },
    methods:{
      get_screen(url, name = false){
        this.loader = true;

        let forPost = {
          'method_name': 'get_screen_by_url',
          'url' : url
        };

        $.post('/api.php', forPost, (res)=>{
          this.loader = false;
          if(!res){ alert('Ошибка: нет ответа от сервера'); }
          else if(res.error){
            console.log(`Ошибка: ${res.error}`); alert(`Ошибка: ${res.error}`);  }
          else{
            let newItem   = res.response;
            newItem.show  = false;
            if(name){ newItem.name = name; }
            this.screens.push(newItem);
          }
        });
      },
      add_new_url(){
        if(!this.url_input){ return false; }
        this.get_screen(this.url_input);
        this.url_input = '';
      }
    },
    created(){
      const startData = [
        // {url:"http://google.com", name: "Google"},
        // {url:"http://yahoo.com", name: "Yahoo"},
        {url:"http://bing.com", name: "Bing"},
      ];

      startData.forEach((item)=>{
        this.get_screen(item.url, item.name);
      });

    }

  })
</script>

</body>
</html>
