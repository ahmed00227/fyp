
<html>
<link rel="stylesheet" href="css/bootstrap/CSS/bootstrap-4.0.0-dist/css/bootstrap.css">
    <link rel="stylesheet" href="css/styling.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" /> 
     <title>Chatbot</title>
    <body>
<div class="des_mode_bg">
  <div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="chatbox">
             <h2>chatbot</h2>
                <ul class="chatbox-body">
                  <li class="chat incoming">
                  <i class="fa-solid fa-robot"></i>
                  <p>hi there 👋<br>how can i help you?</p>
                  </li>
                  <!-- <li class="chat outgoing">
                 <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>              
                  </li> -->
                 </ul>
                 <div class="chat-input">
                  <textarea name="" id="" placeholder="Enter a message...." required></textarea>
                  <i class="fa fa-paper-plane" aria-hidden="true"></i>
                 </div>
        </div>
    </div>
  </div>
</div>
    </body>
    <script>
      const chatInput=document.querySelector(".chat-input textarea");
      const chat_sendbtn=document.querySelector(".chat-input i");
      const chatbox_body=document.querySelector(".chatbox-body ");
      const createchatli=(message,classname)=>{
        //create a chat <li> element with passed message and classname
        const chatLi=document.createElement("li");
        chatLi.classList.add("chat",classname);
        let chat_content=classname==="outgoing" ? ` <p>${message}</p> `:`<i class="fa-solid fa-robot"></i> <p>${message}</p> `;
        chatLi.innerHTML=chat_content;
        return chatLi;
      }
      // const generate_response=()=>{
      //   const API_URL="https://api.openai.com/v1/chat/completions";
      //   const request_options={
      //     method:"POST",
      //     headers:{
      //       "content-type":"application/json",
      //       "Authorization":`Bearer ${API_KEY}`
      //     },
      //     body:JSON.stringify({
      //       model: "gpt-4o",
      //       messages: [ { role: "user", content: usermessage} ]
      //     })
      //   }

      // }
      let usermessage;
      // const API_KEY
      const handlechat=() =>{
       usermessage=chatInput.value.trim();
     if(!usermessage)return;
     //append the user's message to the chatbox
     chatbox_body.appendChild(createchatli(usermessage,"outgoing"))
     setTimeout(()=>{
      //display thinking...message while waiting for the response
      chatbox_body.appendChild(createchatli("Thinking...","incoming"))
      },600);
      // generate_response();
      }
     
      chat_sendbtn.addEventListener("click",handlechat);
    </script>
</html>