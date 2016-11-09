  <style>
   body {
    background: url(img/city.png) repeat-x 0 100% fixed,
                url(img/cloud.png) no-repeat fixed,
                url(img/cloud.png) no-repeat fixed,
                linear-gradient(to top, #5080b1, #004e8c) fixed;
    animation: city 30s linear infinite;
    -webkit-animation: city 30s linear infinite;
   }
   @keyframes city {
    from { background-position: -1000px 100%, 120% 30%, 120% 15%, 0 0;}
    to { background-position: 0 100%, -200% 10%, -50% 15%, 0 0; }
   }
   @-webkit-keyframes city {
    from { background-position: -1000px 100%, 120% 30%, 120% 15%, 0 0;}
    to { background-position: 0 100%, -200% 10%, -50% 15%, 0 0; }
   }
  </style>