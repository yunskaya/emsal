@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Chat App</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <button onClick="window.location.reload();">Refresh</button>

                    <div style="border:1px solid black; margin-top:20px; height:500px; overflow:scroll;" id="messageBox" >
                        @foreach ($messages as $message)    
                            <div class="row" style="border:1px solid black; margin:10px">
                                <p style="float:left; margin-left:5px;">{{ $message->user_name }}</p>
                                <p style="margin-left:6px; float:left;">{{ $message->message }}</p>
                            </div>
                        @endforeach
                    </div>

                    <form class="form" method="POST" action="" style="margin-top:10px;">
                    
                    <textarea type="text" style="width: 100%; resize: none;" name="message" id="message" placeholder="Mesajınızı Giriniz." required></textarea>

                    <button type="button" id="send">Gönder</button>

                    </form>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
 
<script src="{{ asset('js/app.js') }}"></script>
<script type="text/javascript">

            Echo.channel('message').listen('Chat', (e) => {
                console.log(e);
                createDiv(e.message,e.userId);
            
            });

            function createDiv(message,userId){
                
            var newMessageDiv = document.createElement("div");
            var messageBox = document.querySelector('#messageBox');
            var newContent = document.createElement("p");
            var newUser = document.createElement("p");
            
            newUser.style.cssText="float:left; margin-left:5px;";
            newContent.style.cssText="margin-left:6px; float:left;";
            newMessageDiv.style.cssText='border: 1px solid black; margin:10px; ';
            newMessageDiv.className='row';
            newContent.innerHTML=message;
            newUser.innerHTML=userId + " : ";
            
            messageBox.appendChild(newMessageDiv);
            newMessageDiv.appendChild(newUser);
            newMessageDiv.appendChild(newContent);

            }

            $('body').on('click','#send',function(e){
                e.preventDefault();
                var message=$('#message').val();
                console.log(message);
                $.ajax({
                     url: "/sendmessage",
                     method: "get",
                     data: {message:message},
                     dataType: "json",
                     success: function (res) {
                     },
                     error: function (res) {
                     }
                 });
            });
</script>
@endpush