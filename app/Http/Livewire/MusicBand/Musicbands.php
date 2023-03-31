<?php

namespace App\Http\Livewire\MusicBand;

use Livewire\Component;
use App\Models\Musicband;
use Carbon\Carbon;

use Livewire\WithFileUploads;
use Livewire\WithPagination;


class Musicbands extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    use WithFileUploads;

    public $image, $selectedMusicBarId, $name, $location, $rate, $musicbar_edit_id, $musicbar_delete_id;
    public $genre = '';

    public function addBar()
    {

        $this->validate([
            'image' => 'required',
            'name' => 'required',
            'location' => 'required',
            'rate' => 'required',
            'genre' => 'required',

        ]);

        $musicbar = new Musicband();

        $imageName = Carbon::now()->timestamp. '.' .$this->image->extension();
        $this->image->storeAs('image_uploads', $imageName);
        $this->checkedFruits = $this->genre;

        $musicbar->image = $imageName;
        $musicbar->name = $this->name;
        $musicbar->location = $this->location;
        $musicbar->rate = $this->rate;
        $musicbar->genre = $this->genre;

        $this->genre = '';
        // $musicbar->modPop = $this->modPop;
        // $musicbar->modReggae = $this->modReggae;
        // $musicbar->modAcoustic = $this->modAcoustic;
        // $musicbar->modClassical = $this->modClassical;


        $musicbar->save();
        $this->dispatchBrowserEvent('barCreated');




        $this->image = '';
        $this->name = '';
        $this->location = '';
        $this->rate = '';
        $this->genre = '';


        session()->flash('message', 'New music bar has been added Successfully');


        $this->musicbar = $musicbar;

    }
    public function viewBar($id)
    {
        $this->selectedMusicBarId = $id;

        $musicbar = Musicband::find($id);
        $this->musicbar = $musicbar;

        $image_url = asset('uploads/image_uploads/' . $musicbar->image);
        $script = "$('#modal-image').attr('src', '{$image_url}');";
        $this->dispatchBrowserEvent('update-image', ['script' => $script]);
    }


    public function editBar($id)
    {

        $this->selectedMusicBarId = $id;

        $musicbar = Musicband::where('id', $id)->first();
        $this->musicbar = $musicbar;

        $this->musicbar_edit_id = $musicbar->id;

        $this->name = $musicbar->name;
        $this->location = $musicbar->location;
        $this->rate = $musicbar->rate;
        $this->genre = $musicbar->genre;



    }

    public function updateBarData()
    {
        $this->validate([

            'name' => 'required',
            'location' => 'required',
            'rate' => 'required',
            'genre' => 'required',

        ]);


        $musicbar = Musicband::where('id', $this->musicbar_edit_id)->first();

        if ($this->image) {
            $imageName = Carbon::now()->timestamp. '.' .$this->image->extension();
            $this->image->storeAs('image_uploads', $imageName);

            $musicbar->image = $imageName;
        }


        $musicbar->name = $this->name;
        $musicbar->location = $this->location;
        $musicbar->rate = $this->rate;
        $musicbar->genre = $this->genre;

        $musicbar->save();

        $this->dispatchBrowserEvent('barSaved');

        session()->flash('edit-info', 'New Music Bar has been updated Successfully');
    }

    public function deleteConfirm($id)
    {
        $this->musicbar_delete_id = $id;
    }

    public function deleteBardata()
    {
        $musicbar = Musicband::where('id', $this->musicbar_delete_id)->first();
        $musicbar->delete();



        // return redirect()->back()->with('success', 'Data deleted successfully!');
        session()->flash('delete-info', 'music bar has been deleted Successfully');

        $this->dispatchBrowserEvent('barDelete');


    }
    public $bandLocation = 'all';
    public $locations;

    // public $locations = [];

    // public $selectedLocation = '';

    public function mount()
    {
        $this->locations = Musicband::pluck('location')->unique()->toArray();
    }

    public function index()
    {

        $query = Musicband::orderby('id')->search($this->bandSearch);
        return view('components.musicband');

    }

    public $bandSearch;
    public $genRock, $genPop, $genReggae, $genAcoustic, $genClassical;

    public $sortBy = 'sortby';
    public $sortRate = 0;

    public function render()
    {
        $query = Musicband::search($this->bandSearch);

        if ($this->sortRate <= 100) {
            $query = $query->where('rate', '>=', $this->sortRate);
        }

        // $listings = Listing::when($this->selectedLocation, function ($query, $location) {
        //     return $query->where('location', $location);
        // })->get();

        // return view('livewire.listings-index', [
        //     'listings' => $listings,
        // ]);















        // $musicbands = MusicBand::all();
        // $query = MusicBand::query();

        if ($this->bandLocation != 'all') {
            $query->where('location', $this->bandLocation);
        }

        // $musicbands = $query->get();

        // return view('components.musicband', [
        //     'musicbands' => $musicbands
        // ]);


        // if($this->bandLocation != 'all'){
        //     $query->where('location', $this->bandLocation);
        // }


        // if ($this->bandLocation != 'all') {
        //     $selectedLocations[] = $this->bandLocation;
        // }

        // if (!empty($this->selectedLocations)) {
        //     $query->whereIn('location', $this->selectedLocations);
        // }

        // if (!empty($selectedLocations)) {
        //     $query->whereIn('location', $selectedLocations);
        // }


        // $this->locations = Musicband::pluck('location')->unique()->toArray();


        // $musicbands = Musicband::query()
        //     ->when(!empty($this->selectedLocations), function ($query) {
        //         $query->whereIn('location', $this->selectedLocations);
        //     })
        //     ->paginate(4);

        // return view('livewire.music-band.musicbands', [
        //     'musicbands' => $musicbands,
        //     'locations' => $this->locations,
        // ]);



        if ($this->sortBy == 'Lowest to Highest Fee') {
            $query = $query->orderBy('rate', 'asc');

        }
        elseif ($this->sortBy == 'Highest to Lowest Fee') {
            $query = $query->orderBy('rate', 'desc');
        }


        // if($this->genRock == 'Rock' || $this->genPop == 'Pop' || $this->genReggae == 'Reggae' || $this->genAcoustic == 'Acoustic' || $this->genClassical == 'Classical'){
        //     $query->where('genre', $this->genRock)
        //     // $query->where('genre', $this->genPop);
        //     // $query->where('genre', $this->genReggae);
        //     // $query->where('genre', $this->genAcoustic);
        //     // $query->where('genre', $this->genClassical);
        //             ->orWhere('genre', $this->genPop)
        //             ->orWhere('genre', $this->genReggae)
        //             ->orWhere('genre', $this->genAcoustic)
        //             ->orWhere('genre', $this->genClassical);
        // }

        // if ($this->genRock == 'Rock' || $this->genPop == 'Pop' || $this->genReggae == 'Reggae' || $this->genAcoustic == 'Acoustic' || $this->genClassical == 'Classical') {

        //         $query->where('genre', $this->genRock)
        //             ->orWhere('genre', $this->genPop)
        //             ->orWhere('genre', $this->genReggae)
        //             ->orWhere('genre', $this->genAcoustic)
        //             ->orWhere('genre', $this->genClassical);

        // }


        $selectedGenres = [];

        // if ($this->genRock == 'Rock' || $this->genPop == 'Pop' || $this->genReggae == 'Reggae' || $this->genAcoustic == 'Acoustic' || $this->genClassical == 'Classical') {
        //     if($this->genRock == 'Rock'){
        //         $selectedGenres = 'Rock';
        //         $query->where('genre','Rock');
        //     }
        //     if($this->genPop == 'Pop'){
        //         $selectedGenres = 'Pop';
        //         $query->where('genre','Pop');
        //     }
        //     if($this->genReggae == 'Reggae'){
        //         $selectedGenres = 'Reggae';
        //         $query->where('genre','Reggae');
        //     }
        //     if($this->genAcoustic == 'Acoustic'){
        //         $selectedGenres = 'Acoustic';
        //         $query->where('genre','Acoustic');
        //     }
        //     if($this->genClassical == 'Classical'){
        //         $selectedGenres = 'Classical';
        //         $query->where('genre','Classical');
        //     }
        // }

        if ($this->genRock == 'Rock' || $this->genPop == 'Pop' || $this->genReggae == 'Reggae' || $this->genAcoustic == 'Acoustic' || $this->genClassical == 'Classical') {
            $query->where(function ($q) use ($selectedGenres) {
                if ($this->genRock == 'Rock') {
                    $selectedGenres[] = 'Rock';
                    $q->orWhere('genre', 'Rock');
                }
                if ($this->genPop == 'Pop') {
                    $selectedGenres[] = 'Pop';
                    $q->orWhere('genre', 'Pop');
                }
                if ($this->genReggae == 'Reggae') {
                    $selectedGenres[] = 'Reggae';
                    $q->orWhere('genre', 'Reggae');
                }
                if ($this->genAcoustic == 'Acoustic') {
                    $selectedGenres[] = 'Acoustic';
                    $q->orWhere('genre', 'Acoustic');
                }
                if ($this->genClassical == 'Classical') {
                    $selectedGenres[] = 'Classical';
                    $q->orWhere('genre', 'Classical');
                }
            });
        }

        // if($this->genRock == 'Rock'){
        //     $query->where('genre', $this->genRock);
        // }

        // elseif($this->genPop == 'Pop'){
        //     $query->where('genre', $this->genPop);
        // }

        // elseif($this->genReggae == 'Reggae'){
        //     $query->where('genre', $this->genReggae);
        // }

        // elseif($this->genAcoustic == 'Acoustic'){
        //     $query->where('genre', $this->genAcoustic);
        // }

        // elseif($this->genClassical == 'Classical'){
        //     $query->where('genre', $this->genClassical);
        // }


        $musicbar = $query->paginate(4);

        return view('livewire.music-band.musicbands', ['musicbands'=>$musicbar]);
    }




    public function resetFilter(){

        $this->bandSearch = '';

        $this->genRock = null;
        $this->genPop = null;
        $this->genReggae = null;
        $this->genAcoustic = null;
        $this->genClassical = null;

        $this->bandLocation = 'all';

        $this->sortRate = 0;
        $this->sortBy = 'Sort By';


    }
}
