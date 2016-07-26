/*mobile*/
@media all and (min-width: 270px) {
	#info-user{
        margin-bottom: 30px;
    }
    #info-user h2{
        font-size: 160%;
        margin-bottom: 20px;
    }
    #info-user .left-user{
        width: 80%;
        list-style: none;
        margin: 0 auto 30px auto;
        padding: 0 0 20px 0;
        border: solid 1px #CCC;
        border-radius: 8px;
    }
    #info-user .left-user li{
        list-style: none;
        line-height: 55px;
        margin: 0 15px;
        border-bottom: dashed 1px #CCC;
    }
    #info-user .left-user li a{
        color: #666;
        font-size: 110%;
    }
    #info-user .left-user .active{
        font-weight: bold;
    }
    
    #info-user .right-user{
        width: 80%;
        margin: auto;
    }
    #info-user .right-user .info-user{
        font-size: 110%;
    }
    #info-user .right-user .frm-user{
        display: none;
    }
}

/*tablet*/
@media all and (min-width: 600px) {
	#info-user .left-user{
        width: 38%;
        float: left;
    }
    #info-user .right-user{
        width: 55%;
        float: right;
    }
}

/*desktop*/
@media all and (min-width: 1024px) {
	#info-user .left-user{
        width: 25%;
        float: left;
    }
    #info-user .right-user{
        width: 70%;
        float: right;
    }
    #info-user .right-user .iAC-Collection{
        width: 50%;
        margin-left: 10%;
    }
}