<?php

namespace App\Services;

use App\Models\PostImage;
use App\Models\Post;
use App\Models\PostDate;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostService
{
    public function getAll(): Collection
    {
        return Post::with('postDates', 'postImages')->get();
    }

    public function show($id)
    {
        return Post::with('postDates', 'postImages')->find($id);
    }

    public function store(array $data): void
    {
        if (isset($data['cover_picture'])) {
            $coverPictureName = Str::random(32).'.'
                .$data['cover_picture']->getClientOriginalExtension();

            Storage::disk('public')->put(
                '/PostCoverPictures/'.$coverPictureName,
                file_get_contents($data['cover_picture'])
            );

            Post::create([
                'title'         => $data['title'],
                'cover_picture' => $coverPictureName,
                'description'   => $data['description'],
                'trailer'       => $data['trailer'],
                'category'      => $data['category'],
                'subcategory'   => $data['subcategory'],
            ]);
        } else {
            Post::create([
                'title'       => $data['title'],
                'description' => $data['description'],
                'trailer'     => $data['trailer'],
                'category'    => $data['category'],
                'subcategory' => $data['subcategory'],
            ]);
        }
//
//        $postId = Post::query()->latest()->first()->id;
//
//        PostDate::create([
//            'day'         => $data['day'],
//            'month'       => $data['month'],
//            'day_of_week' => $data['day_of_week'],
//            'duration'    => $data['duration'],
//            'cinema'      => $data['cinema'],
//            'hall'        => $data['hall'],
//            'price'       => $data['price'],
//            'age_limit'   => $data['age_limit'],
//            'time'        => $data['time'],
//            'post_id'     => $postId,
//        ]);
    }

    public function storeImages($id, $images): void
    {
        foreach ($images as $image) {
            $imageName = Str::random(32).'.'.$image->getClientOriginalExtension(
                );

            Storage::disk('public')->put(
                '/PostPictures/'.$imageName,
                file_get_contents($image)
            );

            PostImage::create([
                'image'      => $imageName,
                'post_id'    => $id,
            ]);
        }
    }

    public function storeDates($id, $dates): void
    {
        foreach ($dates as $date) {
            PostDate::create([
                'day'         => $date['day'],
                'month'       => $date['month'],
                'day_of_week' => $date['day_of_week'],
                'duration'    => $date['duration'],
                'cinema'      => $date['cinema'],
                'hall'        => $date['hall'],
                'price'       => $date['price'],
                'age_limit'   => $date['age_limit'],
                'time'        => $date['time'],
                'post_id'     => $id,
            ]);
        }
    }


    // Update logic (petqa dzvi kesna grac)

    public function update($id, array $data)
    {
        $movie = Post::findOrFail($id);

        if (isset($data['cover_picture']) && $data['cover_picture'] != '') {
            return $this->updateWithIcon($movie, $data);
        }

        return $this->updateWithoutIcon($movie, $data);
    }

    public function updateWithIcon($movie, $data)
    {
        $oldCoverPictureName = $movie['cover_picture'];
        $newCoverPicture = $data['cover_picture'];
        $newCoverPictureName = Str::random(32).'.'
            .$newCoverPicture->getClientOriginalExtension();

        Storage::disk('public')->delete(
            'MovieCoverPictures/'.$oldCoverPictureName
        );
        Storage::disk('public')->put(
            '/partners/'.$newCoverPictureName,
            file_get_contents($newCoverPicture)
        );

        return $movie->update([
            'title'         => $data['title'],
            'cover_picture' => $newCoverPictureName,
            'description'   => $data['description'],
            'day'           => $data['day'],
            'day_of_week'   => $data['day_of_week'],
            'duration'      => $data['duration'],
            'cinema'        => $data['cinema'],
            'hall'          => $data['hall'],
            'price'         => $data['price'],
            'age_limit'     => $data['age_limit'],
            'time'          => $data['time'],
        ]);
    }

    public function updateWithoutIcon($movie, $data)
    {
        return $movie->update([
            'title'       => $data['title'],
            'description' => $data['description'],
            'day'         => $data['day'],
            'day_of_week' => $data['day_of_week'],
            'duration'    => $data['duration'],
            'cinema'      => $data['cinema'],
            'hall'        => $data['hall'],
            'price'       => $data['price'],
            'age_limit'   => $data['age_limit'],
            'time'        => $data['time'],
        ]);
    }

    public function destroy($id)
    {
        $movie = Post::findOrFail($id);
        $coverPictureName = $movie['cover_picture'];

        Storage::disk('public')->delete(
            'MovieCoverPictures/'.$coverPictureName
        );

        return $movie->delete();
    }
}
