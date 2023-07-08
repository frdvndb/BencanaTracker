<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LaporanBencanaModel;
use App\Models\VoteModel;

class VoteController extends BaseController
{
    public function upVote($id)
    {
        $sessionNow = session()->get('id');
        $model = new LaporanBencanaModel();
        $model2 = new VoteModel();
        $vote = $model->where('id', $id)->first();
        $vote2 = $model2->where('id_laporan', $id)
                ->where('id_user',$sessionNow)
                ->first();
        $model->update($vote['id'], ['jumlah_upvote' => $vote['jumlah_upvote'] + 1]);

        if ($vote2) {
            $data = [
                'id_laporan' => $id,
                'id_user' => $sessionNow,
                'aksi' => 'upvote'
            ];
            $model->update($vote['id'], ['jumlah_downvote' => $vote['jumlah_downvote'] - 1]);
            $model2->update($vote2['id'], $data);
        } else {
            $model2->save([
                'id_laporan' => $id,
                'id_user' => $sessionNow,
                'aksi' => 'upvote'
            ]);
        }
        return redirect()->to(base_url('/laporan/'.$id));
    }

    public function downVote($id)
    {
        $sessionNow = session()->get('id');
        $model = new LaporanBencanaModel();
        $model2 = new VoteModel();
        $vote = $model->where('id', $id)->first();
        $vote2 = $model2->where('id_laporan', $id)
                ->where('id_user',$sessionNow)
                ->first();
        $model->update($vote['id'], ['jumlah_downvote' => $vote['jumlah_downvote'] + 1]);
        if ($vote2) {
            $data = [
                'id_laporan' => $id,
                'id_user' => $sessionNow,
                'aksi' => 'downvote'
            ];
            $model->update($vote['id'], ['jumlah_upvote' => $vote['jumlah_upvote'] - 1]);
            $model2->update($vote2['id'], $data);
        } else {
            $model2->save([
                'id_laporan' => $id,
                'id_user' => $sessionNow,
                'aksi' => 'downvote'
            ]);
        }


        return redirect()->to(base_url('/laporan/'.$id));
    }
}
