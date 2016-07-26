<script>
// Load the SDK asynchronously
(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s); js.id = id;
	js.src = "//connect.facebook.net/en_US/sdk.js";
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

window.fbAsyncInit = function() {
	FB.init({
		appId      : '256333418071321',
		cookie     : true,
		// the session
		xfbml      : true,
		version    : 'v2.2',
	});

	/*FB.getLoginStatus(function(response) {
		statusChangeCallback(response);
	});*/
};

function statusChangeCallback(response) {
	if (response.status === 'connected') {
		getUserInfo();
	} else if (response.status === 'not_authorized') {
		document.getElementById('status').innerHTML = 'Please log into this app.';
	} else {
		document.getElementById('status').innerHTML = 'Please log into Facebook.';
	}
}

function checkLoginState() {
	FB.getLoginStatus(function(response) {
		statusChangeCallback(response);
	});
}

function Login(){
	FB.login(function(response) {
		if (response.authResponse) {
			getUserInfo();
		} else {
			console.log('User cancelled login or did not fully authorize.');
		}
	},{scope: 'email'});
}

function getUserInfo() {
	FB.api('/me?fields=id,name,email', function(response) {
		var fields = new Object();
			fields._request = 'users';
			fields._action = 'loginThirdParty';
			fields.name = response.name;
			fields.email = response.email;
			fields.login = {name:'facebook', id:response.id, img:'https://graph.facebook.com/' + response.id + '/picture?type=large'};

		checkUsers(fields);
	});
}

function Logout(){
	FB.logout(function(){document.location.reload();});
}
</script>

<div class="box2" onClick="Login();"><span class="icon facebook">f</span>Login facebook</div>
<div id="status" class="hidden"></div>