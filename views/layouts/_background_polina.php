<style>
video {
position: fixed;
right: 0;
bottom: 0;
min-width: 100%;
min-height: 100%;
width: auto;
height: auto;
z-index: -100;
background-size: cover;
}

.overlay {
width: 400px;
height: 400px;
border-radius: 50%;
-webkit-border-radius: 50%;
-moz-border-radius: 50%;
background: rgba(0,0,0,0.3);
display: block;
position: absolute;
top: 10%;
left: 50%;
}

.overlay h1 {
text-align: center;
padding-top: 100px;
color: #fff;
font-family: inherit;
}

.overlay p{
text-align: center;
width: 80%;
margin: 0 auto;
color: #fff;
font-family: inherit;
margin-bottom: 20px;
}

.overlay a {
color: #fff;
}

.orange {
text-decoration: none;
}
p a.orange {
color: #f27950;
}
</style>


<video autoplay  poster="https://s3-us-west-2.amazonaws.com/s.cdpn.io/4273/polina.jpg" id="bgvid" loop>
<source src="//demosthenes.info/assets/videos/polina.webm" type="video/webm">
<source src="//demosthenes.info/assets/videos/polina.mp4" type="video/mp4">
</video>
