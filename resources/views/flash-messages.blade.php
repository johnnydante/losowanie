
                @if ($message = Session::get('success'))

                    <div class="alert alert-success alert-block" style="opacity: 0.8;">

                        <button type="button" class="close" data-dismiss="alert">×</button>

                        <strong>{{ $message }}</strong>

                    </div>

                @endif


                @if ($message = Session::get('danger'))

                    <div class="alert alert-danger alert-block" style="opacity: 0.8;">

                        <button type="button" class="close" data-dismiss="alert">×</button>

                        <strong>{{ $message }}</strong>

                    </div>

                @endif
