
<div style="margin-top: 100px;">
 <div class="card-left card rounded-lg p-2 m-5">
       <div class="card-body">
                    <input type="text" name="" id="" placeholder="Search Name" class="form-control m-2 mb-4" wire:model='bandSearch'>

                    <div class="checkbox d-block m-2">

                    <label for="genre">Genre:</label> <br>
                        <input type="checkbox" name="" id="" wire:model='genRock' value="Rock"> &nbsp; Rock <br>
                        <input type="checkbox" name="" id="" wire:model='genPop' value="Pop"> &nbsp; Pop <br>
                        <input type="checkbox" name="" id="" wire:model='genReggae' value="Reggae"> &nbsp; Reggae <br>
                        <input type="checkbox" name="" id="" wire:model='genAcoustic' value="Acoustic"> &nbsp; Acoustic <br>
                        <input type="checkbox" name="" id="" wire:model='genClassical' value="Classical" class="mb-4"> &nbsp; Classical <br>
                    </div>

                   <select name="" id="" class="form-select mb-4" style="transform: translateX(7px);" wire:model='bandLocation'>
                        <option value="all">Select Location</option>
                        @foreach ($musicbands as $musicbar)
                            <option value="{{ $musicbar->location }}">{{ $musicbar->location }}</option>
                        @endforeach
                   </select>
                   <div class="rate d-inline-block mt-2" style="transform: translateX(6px);">
                        <label for="">Rate:</label><br>
                        <input style="width: 350px;" type="range" id="sortRangeInput" name="sortRangeInput" min="0" max="100"
                        oninput="showSortValue(this.value)" wire:model='sortRate'> <br>
                        {{-- <div id="sortRangeInput">Current sort rate: {{ number_format($sortRate, 2) }}</div> --}}
                        ₱ <output class="mb-4" id="sortRangeInput" for="sortRangeInput">{{ number_format(floatval($sortRate), 2) }}</output>


                        {{-- <input style="width: 450px;" type="range" id="editRangeInput" name="editRangeInput" min="0" max="10000"
                        oninput="editShowValue(this.value)" wire:model='rate'> <br>

                        ₱ <output id="newEditAmount" name="newEditAmount" for="editRangeInput">{{ number_format(floatval($rate), 2) }}</output> --}}
                   </div>
                   <br>
                        <select name="" id="" class="form-select" style="transform: translateX(6px);" wire:model='sortBy'>
                            <option value=''>Sort By</option>
                            <option value="Lowest to Highest Fee">Lowest to Highest Fee</option>
                            <option value="Highest to Lowest Fee">Highest to Lowest Fee</option>
                        </select>


                        <button class="btn btn-primary float-end mt-5" wire:click='resetFilter'>Reset Filter</button>

                </div>
</div>

            <div style="margin-top: -670px;">
                <button class="btn btn-primary mt-5 float-end" style="margin-right: 75px; margin-bottom: -100px;"
                data-bs-toggle="modal" data-bs-target="#addNew">Create New</button>


                <div class="right" style="margin-left: 600px; margin-top: -725px;">
                    @if ($musicbands->count()>0)
                    @foreach ($musicbands as $musicbar)
                    <div class="mb-3 card-left card float-start me-lg-5" style="width: 600px; margin-top: 100px;">
                        <div class="card-body d-flex">


                            <img class="viewImg rounded" data-bs-toggle="modal" data-bs-target="#view" wire:click='viewBar({{$musicbar->id}})' width="250"  src="" alt=""
                            style="background-image: url({{asset('uploads/image_uploads')}}/{{$musicbar->image}}); background-size:cover;">



                            <div class="fields ms-3">
                                Name: {{$musicbar->name}}<br> <br>
                                Location: {{$musicbar->location}}<br> <br>
                                Rate: {{ number_format($musicbar->rate, 2) }}<br> <br>
                                Genre: {{$musicbar->genre}}<br> <br>
                            </div>
                        </div>
                        <div class="action d-flex mb-3" style="margin-left: 425px; margin-top: -75px;">
                            <button class="btn btn-success m-2" data-bs-toggle="modal" data-bs-target="#edit" wire:click='editBar({{$musicbar->id}})'>Edit</button>
                            <button class="btn btn-danger m-2" data-bs-toggle="modal" data-bs-target="#delete" wire:click='deleteConfirm({{$musicbar->id}})'>Delete</button>

                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>




            </div>

<footer>
    <div class="float-start" style="margin-top: 50px; margin-left: 1125px;">

        {{$musicbands->links()}}
    </div>
</footer>

  <div wire:ignore.self style="margin-top: 100px;" class="modal text-black fade" id="addNew" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Create New Bar</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">


            <form wire:submit.prevent='addBar'>
                <div class="elements mb-3">
                    <input type="file" name="" id="" class="form-control" wire:model='image'>
                    @if ($image && $image instanceof \Illuminate\Http\UploadedFile)
                        <img src="{{$image->temporaryUrl()}}" width="200" alt="" class="mt-3 rounded">
                    @endif
                    @error('image')
                    <span class="text-danger text-lg">{{$message}}</span>
                    @enderror
                </div>
                <div class="elements">
                    <label for="name">Name:</label><br>
                    <input type="text" name="" id="name" class="form-control" wire:model='name'>
                    @error('name')
                    <span class="text-danger text-lg">{{$message}}</span>
                    @enderror
                </div>
                <div class="elements">
                    <label for="loc">Location:</label><br>
                    <input type="text" name="" id="loc" class="form-control" wire:model='location'>
                    @error('location')
                    <span class="text-danger text-lg">{{$message}}</span>
                    @enderror
                </div>
                <div class="rate d-inline-block mt-2" style="transform: translateX(6px);">
                    <label for="">Rate:</label><br>
                    <input style="width: 450px;" type="range" id="newRangeInput" name="newRangeInput" min="0" max="100"
                    oninput="showValue(this.value)" wire:model='rate'> <br>

                    ₱ <output id="newAmount" name="amount" for="newRangeInput">{{ number_format(floatval($rate), 2) }}</output>
                    @error('rate')
                    <span class="text-danger text-lg">{{$message}}</span>
                    @enderror
               </div>
                {{-- <div class="elements">
                    <label for="rate">Rate:</label><br>
                    <input type="range" name="" id="rate" class="" wire:model='rate'>
                    @error('rate')
                    <span class="text-danger text-lg">{{$message}}</span>
                    @enderror
                </div> --}}
                <div class="elements">
                    <label for="gen">Genre:</label><br>


                    <select name="" id="" wire:model='genre' class="form-select">
                        <option value="">Select Genre</option>
                        <option value="Rock">Rock</option>
                        <option value="Pop">Pop</option>
                        <option value="Reggae">Reggae</option>
                        <option value="Acoustic">Acoustic</option>
                        <option value="Classical">Classical</option>
                    </select>

                    {{-- <input type="checkbox" name="" id="" value="Rock" wire:model.defer='genre'>Rock <br>
                    <input type="checkbox" name="" id="" value="Pop" wire:model.defer='genre'>Pop <br>
                    <input type="checkbox" name="" id="" value="Reggae" wire:model.defer='genre'>Reggae <br>
                    <input type="checkbox" name="" id="" value="Acoustic" wire:model.defer='genre'>Acoustic <br>
                    <input type="checkbox" name="" id="" value="Classical" wire:model.defer='genre'>Classical --}}


                    @error('genre')
                        <span class="text-danger text-lg">{{ $message }}</span>
                    @enderror


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" >Create</button>
                  </div>
            </form>
        </div>

      </div>
    </div>
  </div>

  <div wire:ignore.self class="modal fade text-black" id="edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Bar</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form wire:submit.prevent='updateBarData'>
                <div class="elements mb-3">

                    <input type="file" name="" id="" class="form-control" wire:model='image'>
                    @foreach ($musicbands as $musicbar)
                        @if ($musicbar->id === $selectedMusicBarId)
                            <img src="{{ asset('uploads/image_uploads/' . $musicbar->image) }}" width="250" class="rounded" alt="">
                        @endif
                    @endforeach

                    @if ($image && $image instanceof \Illuminate\Http\UploadedFile)

                        <img src="{{$image->temporaryUrl()}}" width="200" alt="" class="mt-3 rounded">
                    @endif

                    @error('image')
                    <span class="text-danger text-lg">{{$message}}</span>
                    @enderror
                </div>
                <div class="elements">
                    <label for="name">Name:</label><br>
                    <input type="text" name="" id="name" class="form-control" wire:model='name'>
                    @error('name')
                    <span class="text-danger text-lg">{{$message}}</span>
                    @enderror
                </div>
                <div class="elements">
                    <label for="loc">Location:</label><br>
                    <input type="text" name="" id="loc" class="form-control" wire:model='location'>
                    @error('location')
                    <span class="text-danger text-lg">{{$message}}</span>
                    @enderror
                </div>
                <div class="rate d-inline-block mt-2" style="transform: translateX(6px);">
                    <label for="">Rate</label><br>
                    <input style="width: 450px;" type="range" id="editRangeInput" name="editRangeInput" min="0" max="100"
                    oninput="editShowValue(this.value)" wire:model='rate'> <br>

                    ₱ <output id="newEditAmount" name="newEditAmount" for="editRangeInput">{{ number_format(floatval($rate), 2) }}</output>
                    @error('rate')
                    <span class="text-danger text-lg">{{$message}}</span>
                    @enderror
               </div>
                {{-- <div class="elements">
                    <label for="rate">Rate:</label><br>
                    <input type="number" name="" id="rate" class="form-control" wire:model='rate'>
                    @error('rate')
                    <span class="text-danger text-lg">{{$message}}</span>
                    @enderror
                </div> --}}
                <div class="elements">
                    <label for="gen">Genre:</label><br>
                    {{-- <input type="text" name="" id="gen" class="form-control" wire:model='genre'> --}}
                    <select name="" id="" wire:model='genre' class="form-select">
                        <option value="">Select Genre</option>
                        <option value="Rock">Rock</option>
                        <option value="Pop">Pop</option>
                        <option value="Reggae">Reggae</option>
                        <option value="Acoustic">Acoustic</option>
                        <option value="Classical">Classical</option>


                    </select>
                    @error('genre')
                    <span class="text-danger text-lg">{{$message}}</span>
                    @enderror
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                  </div>
            </form>
        </div>

      </div>
    </div>
  </div>

  <div wire:ignore.self class="modal fade text-black" id="delete" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Delete Bar</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <h1 class="text-black">Delete</h1>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-danger" wire:click='deleteBardata' data-bs-dismiss="modal">Delete</button>
        </div>
      </div>
    </div>
  </div>


  <div wire:ignore.self class="modal mt-5 fade text-black" id="view" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body p-5">
            <div class="imageView text-center">
                @foreach ($musicbands as $musicbar)
                @if ($musicbar->id === $selectedMusicBarId)
                    <img src="{{ asset('uploads/image_uploads/' . $musicbar->image) }}" width="250" class="rounded imageViewCss" alt="">
                @endif
            @endforeach
            <h4>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nemo adipisci amet perferendis eos? Molestias adipisci maxime saepe enim officia sapiente molestiae dolore, necessitatibus aperiam excepturi veritatis doloribus, fugiat voluptate inventore.</h4>
            <button class="btn btn-primary">Book Now</button>
            </div>


            <br> <br> <br>
            <div class="buttonView float-end">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

            </div>


        </div>

      </div>
    </div>
  </div>
  <style>
    .imageViewCss{
        cursor: pointer;
        width: 300px;
        transition: 0.5s;
    }
    .imageViewCss:hover{
        width: 350px;
        transition: 0.5s;
    }
    .viewImg{
        cursor: pointer;
        background-color: rgba(29, 29, 29, 0.403);
        width: 250px;
        transition: 0.5s;
        box-shadow: 3px 3px 0px 0px rgb(31, 31, 31)
    }
    .viewImg:hover{
        transform: translateY(-25px);
        background-color: rgba(57, 57, 57, 0.403);
        width: 250px;
        box-shadow: 25px 25px 0px 0px rgba(31, 31, 31, 0.718)
    }

    .card_data{
        width: 1000px;
    }
    .card-left{
        background-color: rgba(29, 29, 29, 0.403);
        width: 400px;
        transition: 0.5s;
        box-shadow: 3px 3px 0px 0px rgb(31, 31, 31)

    }
    .card-left:hover{
        transform: translateY(-10px);
        background-color: rgba(57, 57, 57, 0.403);
        width: 400px;
        box-shadow: 10px 10px 0px 0px rgb(31, 31, 31)
    }

    </style>

    <script>


function showSortValue(val) {
    var sortdecimalPlaces = 2;

    var sortformattedVal = parseFloat(val).toFixed(sortdecimalPlaces);

    document.getElementById("newSortAmount").innerHTML = sortformattedVal;

    }


    function showValue(val) {
    var decimalPlaces = 2;

    var formattedVal = parseFloat(val).toFixed(decimalPlaces);

    document.getElementById("newAmount").innerHTML = formattedVal;

    }

    function editShowValue(val){
        var editDecimalPlaces = 2;

        var editFormattedVal = parseFloat(val).toFixed(editDecimalPlaces);

        document.getElementById("newEditAmount").innerHTML = editFormattedVal;
    }

    window.addEventListener('barSaved', function() {
    // close the modal
    var addNewModal = document.getElementById('edit');
    if (addNewModal) {
        var modal = bootstrap.Modal.getInstance(addNewModal);
        modal.hide();
    }
});

window.addEventListener('barDeleted', function() {
    // close the modal
    var deleteModal = document.getElementById('delete');
    if (deleteModal) {
        var modal = bootstrap.Modal.getInstance(deleteModal);
        modal.hide();
    }
});

window.addEventListener('barCreated', function() {
    // close the modal
    var deleteModal = document.getElementById('addNew');
    if (deleteModal) {
        var modal = bootstrap.Modal.getInstance(deleteModal);
        modal.hide();
    }
});
    </script>
</div>

