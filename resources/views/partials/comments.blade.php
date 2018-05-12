<div class="row">
    <div class="col-md-12 col-sm-12  col-xs-12 col-lg-12">

        <!-- Fluid width widget -->
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <span class="glyphicon glyphicon-comment"></span> 
                    Recent Comments
                </h3>
            </div>
            <div class="panel-body">
                <ul class="media-list">

                    @foreach($comments as $comment)
                        <li class="media">
                            <div class="media-left">
                                @if($comment->progress >= 8.0)
                                    <img src="http://placehold.it/60x60" class="img-circle">
                                @else
                                    <img src="http://via.placeholder.com/60x60/DF0029" class="img-circle">
                                @endif
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">
                                    <small>
                                        <a href="users/{{$comment->user->id}} "> {{ $comment->user->first_name}} {{ $comment->user->last_name}}
                                            - {{ $comment->user->email}} </a>
                                        <br>commented on {{ $comment->created_at}}
                                    </small>
                                </h4>
                                <p>
                                    <b>Status: </b>{{ $comment->status }}
                                </p>
                                <p>
                                    <b>Progress: </b> {{ $comment->progress }}
                                </p>
                                <p>
                                    {{ $comment->body }}
                                </p>
                                <b> Proof: </b>
                                <p>
                                    {{ $comment->url }}
                                </p>
                            </div>
                        </li>

                    @endforeach
                </ul>
            </div>
        </div>
        <!-- End fluid width widget -->

    </div>
</div>
