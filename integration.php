<html>



<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@440;600;700;800&display=swap" rel="stylesheet">
<style>
    .main_div {
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        font-family: 'Open Sans', sans-serif;

    }

    .table_data {
        color: inherit;
        fill: inherit;
        border: 1px solid rgb(190, 190, 190);
        position: relative;
        vertical-align: top;
        min-width: 174.5px;
        max-width: 240px;
        min-height: 32px;
    }

    .notion-table-cell-text {
        max-width: 100%;
        width: 100%;
        word-break: break-all;
        caret-color: rgb(55, 53, 47);
        padding: 7px 9px;
        background-color: transparent;
        font-size: 14px;
        line-height: 20px;
        overflow: hidden;
    }

    .notion-table-cell-text-withspace{
        max-width: 100%;
        width: 100%;
        caret-color: rgb(55, 53, 47);
        padding: 7px 9px;
        background-color: transparent;
        font-size: 14px;
        line-height: 20px;
        overflow: hidden;
        white-space: pre-line;
    }

    p{
        word-break: normal;
        margin-left: 5px;
        margin-right: 10px;
        white-space: pre-line;
        overflow-wrap: break-word;
    }

</style>

<div class="main_div">
    <table style="margin: 8px 18px 18px 8px;">
        <tbody>
            <tr class="notion-table-row">
                <td class="table_data">
                    <div class="notion-table-cell">
                        <div class="notion-table-cell-text" spellcheck="true" placeholder=" " data-content-editable-leaf="true" contenteditable="false">
                            <span style="font-weight:600" data-token-index="0" class="notion-enable-hover">Name</span>
                        </div>
                    </div>
                </td>
                <td class="table_data">
                    <div class="notion-table-cell">
                        <div class="notion-table-cell-text" spellcheck="true" placeholder=" " data-content-editable-leaf="true" contenteditable="false" >
                            <span style="font-weight:600" data-token-index="0" class="notion-enable-hover">URL</span>
                        </div>
                    </div>
                </td>
                <td class="table_data">
                    <div class="notion-table-cell">
                        <div class="notion-table-cell-text" spellcheck="true" placeholder=" " data-content-editable-leaf="true" contenteditable="false" >
                            <span style="font-weight:600" data-token-index="0" class="notion-enable-hover">Params</span>
                        </div>
                    </div>
                </td>
                <td class="table_data">
                    <div class="notion-table-cell">
                        <div class="notion-table-cell-text" spellcheck="true" placeholder=" " data-content-editable-leaf="true" contenteditable="false" >
                            <span style="font-weight:600" data-token-index="0" class="notion-enable-hover">Result</span>
                        </div>
                    </div>
                </td>
            </tr>
            <tr class="notion-table-row">
                <td class="table_data">
                    <div class="notion-table-cell">
                        <div class="notion-table-cell-text" spellcheck="true" placeholder=" " data-content-editable-leaf="true" contenteditable="false">
                            <br>
                            <span style="font-weight:600" data-token-index="0" class="notion-enable-hover">Email Signup</span>
                            <br>
                            <p> After Login you will receive user info. Save "id" for next quries</p> 
                            <span style="font-weight:600" data-token-index="2" class="notion-enable-hover">
                                <p>You need to send a api-key as http header for any opration in api</p>
                            </span>
                        </div>
                    </div>
                </td>
                <td class="table_data">
                    <div class="notion-table-cell">
                        <div class="notion-table-cell-text" spellcheck="true" placeholder=" " data-content-editable-leaf="true" contenteditable="false" >
                            <p style="color:#0000FF;">http://the-metasoft.tk/Api/api/emailsignup</p>
                            <span style="font-weight:600" data-token-index="1" class="notion-enable-hover">params:- POST</span>
                            <br> <br> <br>
                            <span style="font-weight:600" data-token-index="1" class="notion-enable-hover">header:- HTTP header</span>
                        </div>
                    </div>
                </td>
                <td class="table_data">
                    <div class="notion-table-cell">
                        <div class="notion-table-cell-text-withspace" spellcheck="true" placeholder=" " data-content-editable-leaf="true" contenteditable="false" >
                            <span style="font-weight:600" data-token-index="0" class="notion-enable-hover">Params:</span>
                            <p>"name": "my name"
                            "user_name": "my_username"
                            "email": "my email"
                            "password": "my pass"</p><span style="font-weight:600" data-token-index="0" class="notion-enable-hover">Headers:</span>
                            <p>"API-KEY": "apps api key"</p>
                        </div>
                    </div>
                </td>
                <td class="table_data">
                    <div class="notion-table-cell">
                        <div class="notion-table-cell-text" spellcheck="true" placeholder=" " data-content-editable-leaf="true" contenteditable="false" >
                            <p>Success:-
                            {
                            "code":"200",
                            "msg":"user created successfully"
                            "user":{
                            "id":"1",
                            "name":"name",
                            "user_name":"my username",
                            "email":"email@email.com",
                            "password":"not set yet",
                            "pic":"http://pic.png",
                            "bio":"bio",
                            "verified":"0",
                            "role":"user",
                            "signin_type":"email"
                            }
                            }</p>

                            <p>Error:-
                            {
                            "code":"101",
                            "msg":"error info"
                            }</p>

                        </div>
                    </div>
                </td>
            </tr>

            <!-- second row-->

            <tr class="notion-table-row">
                <td class="table_data">
                    <div class="notion-table-cell">
                        <div class="notion-table-cell-text" spellcheck="true" placeholder=" " data-content-editable-leaf="true" contenteditable="false">
                            
                            <span style="font-weight:600" data-token-index="0" class="notion-enable-hover">Check Username Availablity</span>
                            <br> <br>
                            <p> When users is typing A Username check availability</p> 
                            <span style="font-weight:600" data-token-index="2" class="notion-enable-hover">
                                <p>you can call this on text changes in username box.
                                    duplicate usernames are not allowed.
                                </p>
                            </span>
                        </div>
                    </div>
                </td>
                <td class="table_data">
                    <div class="notion-table-cell">
                        <div class="notion-table-cell-text" spellcheck="true" placeholder=" " data-content-editable-leaf="true" contenteditable="false" >
                            <br> <p style="color:#0000FF;">http://the-metasoft.tk/Api/api/checkusername</p>
                            <span style="font-weight:600" data-token-index="1" class="notion-enable-hover">params:- POST</span>
                            <br> <br> <br>
                            <span style="font-weight:600" data-token-index="1" class="notion-enable-hover">header:- HTTP header</span>
                        </div>
                    </div>
                </td>
                <td class="table_data">
                    <div class="notion-table-cell">
                        <div class="notion-table-cell-text-withspace" spellcheck="true" placeholder=" " data-content-editable-leaf="true" contenteditable="false" >
                            <span style="font-weight:600" data-token-index="0" class="notion-enable-hover">Params:</span>
                            <p>"user_name": "user enterd keyword"
                            </p><span style="font-weight:600" data-token-index="0" class="notion-enable-hover">Headers:</span>
                            <p>"API-KEY": "apps api key"</p>
                        </div>
                    </div>
                </td>
                <td class="table_data">
                    <div class="notion-table-cell">
                        <div class="notion-table-cell-text" spellcheck="true" placeholder=" " data-content-editable-leaf="true" contenteditable="false" >
                        <span style="font-weight:600" data-token-index="0" class="notion-enable-hover">Success:</span>    
                        <p>{
                            "code":"200"
                            "msg":"username available"
                            }
                        </p>
                        <span style="font-weight:600" data-token-index="0" class="notion-enable-hover">Fail/Error:</span>
                        <p>{
                            "code":"101"
                            "msg":"username alredy taken"
                            }
                        </p> 
                        </div>
                    </div>
                </td>
            </tr>

            <!-- third api row-->
            <tr class="notion-table-row">
                <td class="table_data">
                    <div class="notion-table-cell">
                        <div class="notion-table-cell-text" spellcheck="true" placeholder=" " data-content-editable-leaf="true" contenteditable="false">
                            
                            <span style="font-weight:600" data-token-index="0" class="notion-enable-hover">Check Username Availablity</span>
                            <br> <br>
                            <p> When users is typing A Username check availability</p> 
                            <span style="font-weight:600" data-token-index="2" class="notion-enable-hover">
                                <p>you can call this on text changes in username box.
                                    duplicate usernames are not allowed.
                                </p>
                            </span>
                        </div>
                    </div>
                </td>
                <td class="table_data">
                    <div class="notion-table-cell">
                        <div class="notion-table-cell-text" spellcheck="true" placeholder=" " data-content-editable-leaf="true" contenteditable="false" >
                            <br> <p style="color:#0000FF;">http://the-metasoft.tk/Api/api/checkusername</p>
                            <span style="font-weight:600" data-token-index="1" class="notion-enable-hover">params:- POST</span>
                            <br> <br> <br>
                            <span style="font-weight:600" data-token-index="1" class="notion-enable-hover">header:- HTTP header</span>
                        </div>
                    </div>
                </td>
                <td class="table_data">
                    <div class="notion-table-cell">
                        <div class="notion-table-cell-text-withspace" spellcheck="true" placeholder=" " data-content-editable-leaf="true" contenteditable="false" >
                            <span style="font-weight:600" data-token-index="0" class="notion-enable-hover">Params:</span>
                            <p>"user_name": "user enterd keyword"
                            </p><span style="font-weight:600" data-token-index="0" class="notion-enable-hover">Headers:</span>
                            <p>"API-KEY": "apps api key"</p>
                        </div>
                    </div>
                </td>
                <td class="table_data">
                    <div class="notion-table-cell">
                        <div class="notion-table-cell-text" spellcheck="true" placeholder=" " data-content-editable-leaf="true" contenteditable="false" >
                        <span style="font-weight:600" data-token-index="0" class="notion-enable-hover">Success:</span>    
                        <p>{
                            "code":"200"
                            "msg":"username available"
                            }
                        </p>
                        <span style="font-weight:600" data-token-index="0" class="notion-enable-hover">Fail/Error:</span>
                        <p>{
                            "code":"101"
                            "msg":"username alredy taken"
                            }
                        </p> 
                        </div>
                    </div>
                </td>
            </tr>

        </tbody>
    </table>
</div>

</html>