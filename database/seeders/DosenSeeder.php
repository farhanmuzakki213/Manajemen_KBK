<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dosenData = [
            ['ALDE ALANDA, S.Kom, M.T', '0025088802', '198808252015041002', 'Laki-laki', 7, 2, 'alde@pnp.ac.id', bcrypt('12345'), '', '1'],
            ['ALDO ERIANDA, M.T, S.ST', '003078904', '198907032019031015', 'Laki-laki', 7, 1, 'aldo@pnp.ac.id', bcrypt('12345'), '', '1'],
            ['CIPTO PRABOWO, S.T, M.T', '0002037410', '197403022008121001', 'Laki-laki', 7, 2, 'cipto@pnp.ac.id',  bcrypt('12345'), '', '1'],
            ['DEDDY PRAYAMA, S.Kom, M.ISD', '0015048105', '198104152006041002', 'Laki-laki', 7, 2, 'deddy@pnp.ac.id', bcrypt('12345'), '', '1'],
            ['DEFNI, S.Si, M.Kom', '0007128104', '198112072008122001', 'Perempuan', 7, 1, 'defni@pnp.ac.id', bcrypt('12345'), '', '1'],
            ['DENI SATRIA, S.Kom, M.Kom', '0028097803', '197809282008121002', 'Laki-laki', 7, 1, 'dns1st@gmail.com', bcrypt('12345'), '', '1'],
            ['DWINY MEIDELFI, S.Kom, M.Cs', '0009058601', '198605092014042001', 'Perempuan', 7, 3, 'dwinymeidelfi@pnp.ac.id', bcrypt('12345'), '', '1'],
            ['ERVAN ASRI, S.Kom, M.Kom', '0001097802', '197809012008121001', 'Laki-laki', 7, 1, 'ervan@pnp.ac.id', bcrypt('12345'), '', '1'],
            ['FAZROL ROZI, M.Sc.', '0021078601', '19860721201012006', 'Laki-laki', 7, 2, 'fazrol@pnp.ac.id', bcrypt('12345'), '', '1'],
            ['FITRI NOVA, M.T, S.ST', '1029058502', '198505292014042001', 'Perempuan', 7, 2, 'fitrinova85@gmail.com', bcrypt('12345'), '', '1'],
            ['Ir. HANRIYAWAN ADNAN MOODUTO, M.Kom.', '0010056606', '196605101994031003', 'Laki-laki', 7, 2, 'mooduto@pnp.ac.id', bcrypt('12345'), '', '1'],
            ['HENDRICK, S.T, M.T.,Ph.D', '0002127705', '197712022006041000', 'Laki-laki', 4, 3, 'hendrickpnp77@gmail.com', bcrypt('12345'), '', '0'],
            ['HIDRA AMNUR, S.E., S.Kom, M.Kom', '0015048209', '198204152012121002', 'Laki-laki', 7, 1, 'hidra@pnp.ac.id', bcrypt('12345'), '', '1'],
            ['HUMAIRA, S.T, M.T', '0019038103', '198103192006042002', 'Perempuan', 7, 3, 'humaira@pnp.ac.id', bcrypt('12345'), '', 1],
            ['IKHSAN YUSDA PRIMA PUTRA, S.H., LL.M', '0001107505', '197510012006041002', 'Laki-laki', 7, 2, 'ikhsan_yusda@yahoo.com', bcrypt('12345'), '', '1'],
            ['INDRI RAHMAYUNI, S.T, M.T', '0025068301', '198306252008012004', 'Perempuan', 7, 3, 'indri@pnp.ac.id', bcrypt('12345'), '', '1'],
            ['MERI AZMI, S.T, M.Cs', '0029068102', '198106292006042001', 'Perempuan', 7, 1, 'meriazmi@gmail.com', bcrypt('12345'), '', '1'],
            ['Ir. Rahmat Hidayat, S.T, M.Sc.IT', '1015047801', '197804152000121002', 'Laki-laki', 7, 3, 'rahmat@pnp.ac.id', bcrypt('12345'), '', '1'],
            ['RASYIDAH, S.Si, M.M.', '0001067407', '197406012006042001', 'Perempuan', 7, 1, 'rasyidah@pnp.ac.id', bcrypt('12345'), '', '1'],
            ['RIKA IDMAYANTI, S.T, M.Kom', '0022017806', '197801222009122002', 'Perempuan', 7, 3, 'rikaidmayanti@pnp.ac.id', bcrypt('12345'), '', '1'],
            ['RITA AFYENNI, S.Kom, M.Kom', '0018077099', '197007182008012010', 'Perempuan', 7, 1, 'ritaafyenni@pnp.ac.id', bcrypt('12345'), '', '1'],
            ['RONAL HADI, S.T, M.Kom', '0029017603', '197601292002121001', 'Laki-laki', 7, 2, 'ronalhadi@pnp.ac.id', bcrypt('12345'), '', '1'],
            ['TAUFIK GUSMAN,  S.S.T, M.Ds', '0010088805', ' 19880810 201903 1 012', 'Laki-laki', 7, 1, 'taufikgusman@gmail.com', bcrypt('12345'), '', '1'],
            ['YANCE SONATHA, S.Kom, M.T', '0029128003', '198012292006042001', 'Perempuan', 7, 1, 'sonatha.yance@gmail.com', bcrypt('12345'), '', '1'],
            ['Dr. Ir. YUHEFIZAR, S.Kom., M.Kom', '0013017604', '197601132006041002', 'Laki-laki', 7, 1, 'yuhefizar@pnp.ac.id', bcrypt('12345'), '', '1'],
            ['YULHERNIWATI, S.Kom, M.T', '0019077609', '197607192008012017', 'Perempuan', 7, 3, 'yulherniwati@pnp.ac.id', bcrypt('12345'), '', '1'],
            ['TRI LESTARI, S.Pd.,M.Eng.', '0005039205', '199203052019032025', 'Perempuan', 7, 1, 'trilestari0503@gmail.com', bcrypt('12345'), '', '1'],
            ['Fanni Sukma, S.ST., M.T', '0006069009', '199006062019032026', 'Perempuan', 7, 3, 'fannisukma@pnp.ac.id', bcrypt('12345'), '', '1'],
            ['Andre Febrian Kasmar, S.T., M.T.', '0020028804', '198802202019031009', 'Laki-laki', 7, 3, 'andrefebrian@pnp.ac.id', bcrypt('12345'), '', '1'],
            ['RONI PUTRA, S.Kom, M.T ', '0022078607', '198607222009121004', 'Laki-laki', 7, 1, 'rn.putra@gmail.com', bcrypt('12345'), '', '1'],
            ['Ardi Syawaldipa, S.Kom.,M.T.', '0029058909', '19890529 202012 1 003', 'Laki-laki', 7, 2, 'ardi.syawaldipa@gmail.com', bcrypt('12345'), '', '1'],
            ['Harfebi Fryonanda, S.Kom., M.Kom', '0310119101', '19911110 202203 1 008', 'Laki-laki', 7, 3, 'harfebi@pnp.ac.id', bcrypt('12345'), '', '1'],
            ['Ideva Gaputra, S.Kom., M.Kom', '0012098808', '198809122022031006', 'Laki-laki', 7, 2, 'idevagaputra@pnp.ac.id', bcrypt('12345'), '', '1'],
            ['Yulia Jihan Sy, S.Kom., M.Kom', '1017078904', '19890717 202203 2 010', 'Perempuan', 7, 2, 'yulia@pnp.ac.id', bcrypt('12345'), '', '1'],
            ['Andrew Kurniawan Vadreas, S.Kom., M.T	', '1021028702', '19870221 202203 1 001', 'Laki-laki', 7, 1, 'andrew@pnp.ac.id', bcrypt('12345'), '', '1'],
            ['YORI ADI ATMA, S.Pd., M.Kom', '2010059001', '19900510 202203 1 002', 'Laki-laki', 7, 1, 'yori@pnp.ac.id', bcrypt('12345'), '', '1'],
            ['Dr. Ulya Ilhami Arsyah, S.Kom., M.Kom', '0130039101', '19910330 202203 1 004', 'Laki-laki', 7, 3, 'ulya@pnp.ac.id', bcrypt('12345'), '', '1'],
            ['Hendra Rotama, S.Pd., M.Sn', '0218068801', '19880618 202203 1 003', 'Laki-laki', 7, 2, 'hendrarotama@pnp.ac.id', bcrypt('12345'), '', '1'],
            ['Sumema, S.Ds., M.Ds', '0008069103', '19910608 202203 2 006', 'Perempuan', 7, 2, 'sumema@pnp.ac.id', bcrypt('12345'), '', '1'],
            ['Raemon Syaljumairi, S.Kom., M.Kom', '0017078407', '19840717 201012 1 002', 'Laki-laki', 7, 2, 'raemon_syaljumairi@pnp.ac.id', bcrypt('12345'), '', '1'],
            ['Mutia Rahmi Dewi, S.Kom., M.Kom', '0004099601', '19960904 202203 2 018', 'Perempuan', 7, 3, 'mutiarahmi@pnp.ac.id', bcrypt('12345'), '', '1'],
            ['Novi, S.Kom., M.T', '0001118611', '19861101 202203 2 003', 'Perempuan', 7, 2, 'novi@pnp.ac.id', bcrypt('12345'), '', '1'],
            ['Rahmi Putri Kurnia, S.Kom., M.Kom', '0027089303', '19930827 202203 2 012', 'Perempuan', 7, 2, 'rahmiputri@pnp.ac.id', bcrypt('12345'), '', '1']
        ];

        foreach ($dosenData as $data) {
            DB::table('dosen')->insert([
                'nama_dosen' => $data[0],
                'nidn' => $data[1],
                'nip' => $data[2],
                'gender' => $data[3],
                'jurusan_id' => $data[4],
                'prodi_id' => $data[5],
                'email' => $data[6],
                'password' => $data[7],
                'image' => $data[8],
                'status' => $data[9]
            ]);
        }
    }
}
