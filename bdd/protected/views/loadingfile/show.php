<style type="text/css">
    #loadingIcon {
    	width: 100%;
    	height: 100%;
    	background-color: white;
    	background-image: url('images/main/background_main.jpg');
    	background-repeat: repeat-x;
    }
    #divborder {
	    height: 300px;
		width: 500px;
		background-color: white;
		position: absolute;
		top: 50%;
		left: 50%;
		margin-top: -150px;
		margin-left: -250px;
		border: 3px solid;
		border-color: #f9960b;
		border-radius: 12px;
    }
    #divborder div {
	    position: absolute;
	    height: 100px;
	    width: 300px;
	    top: 50%;
	    left: 50%;
	    margin-top: -50px;
	    margin-left: -150px;
    }
    #loadingIcon div div p {
	    text-align: center;
	    font-size: 30px;
	    color: gray;
    }
    #loadingIcon div div img {
	    display: block;
	    width: 50px;
	    margin:auto;
    }

</style>

<div id="loadingIcon">
	<div id="divborder">
		<div>
			<img src="images/main/ajax-loader4.gif"/>
			<p>Loading PDF file...</p>
		</div>
	</div>
</div>