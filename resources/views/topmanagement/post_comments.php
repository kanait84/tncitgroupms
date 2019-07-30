<?php

echo "test";

?>


 if($comment->uid->usertype=='management' || $usertype=='topmanagement' || $usertype=='admin'){ ?>
                            <h4 align="right" style="background:#01a7b3">
                                <p>Manager Name: {{$uname->name}}</p>
                                <p>{{$comment->comment}}</p>
                            </h4>

                        <?php } elseif($usertype=='employee') { ?>
                          <h4 align="left" style="background:#2a9055;">
                                <p>Employee Name: {{$uname->name}}</p>
                                <p>{{$comment->comment}}</p>
                          </h4>
						  