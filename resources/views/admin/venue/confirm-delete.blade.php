 
                  <div class="row">
                       <div class="modal inmodal" id="myModal5" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header modal-bg">
                                            <button type="button" class="close-tab" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <h4 class="modal-title text-white">Delete <span class="text-capitalize">{{$venue->name}}</span> Venue</h4>
                                             <h3 class="font-bold"></h3>
                                        </div>
                                        <form action="{{ route('adminvenues.destroy',['venue'=>$venue])}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                          <div class="modal-body form-group">
                                        <h4 class="text-black font-bold text-center">Are you sure, You want To Delete?</h4>
                                        <h5 class="text-danger text-center"> Note! Once Deleted, It can not be Retrived</h5>
                                             <label for="">Enter Password To Proceed <span > </span></label>
                                             <input type="hidden" value="{{$venue->id}}" name="id">
                                             <input type="password" class="form-control" name="confirm_password">
                                        </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                               <input type="submit" class="btn btn-danger" value="Delete">
                                             </div>
                                        </form>
                                    </div>
                                </div>
                          </div>
                    </div>   

                    <script>
                          $("#myModal5").modal('show');
                      </script>
 