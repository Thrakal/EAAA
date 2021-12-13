<head>
    <script src="js/main.js"></script>
</head>

<body>
    <center>

    <div id="searchResult">- Search Results - </div>
        <br>

        <form>
            <b>Search for someone's firstname:</b><br>
            <input type="text" name="searchInput" onkeyup="search(this.value)" />
        </form>

        <hr>
        <h3>User Authentication</h3>
        <input type="button" value="Auth User" onclick="authUser()">
        <input type="button" value="Get User Data" onclick="userGetData()">
        <input type="button" value="Logout" onclick="userLogout()">
        
        <br><br>
        <div id="jsonResponse"></div>
    </center>
</body>
