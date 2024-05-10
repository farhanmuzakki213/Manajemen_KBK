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
            [13, 'ALDE ALANDA, S.Kom, M.T', '0025088802', '198808252015041002', 'Laki-laki', 7, 19, 'alde@pnp.ac.id', '12345678', '', '1'],
            [14, 'ALDO ERIANDA, M.T, S.ST', '003078904', '198907032019031015', 'Laki-laki', 7, 18, 'aldo@pnp.ac.id', '12345678', '', '1'],
            [40, 'CIPTO PRABOWO, S.T, M.T', '0002037410', '197403022008121001', 'Laki-laki', 7, 19, 'cipto@pnp.ac.id', '12345678', '', '1'],
            [46, 'DEDDY PRAYAMA, S.Kom, M.ISD', '0015048105', '198104152006041002', 'Laki-laki', 7, 19, 'deddy@pnp.ac.id', '12345678', '', '1'],
            [50, 'DEFNI, S.Si, M.Kom', '0007128104', '198112072008122001', 'Perempuan', 7, 18, 'defni@pnp.ac.id', '12345678', '', '1'],
            [52, 'DENI SATRIA, S.Kom, M.Kom', '0028097803', '197809282008121002', 'Laki-laki', 7, 18, 'dns1st@gmail.com', '12345678', '', '1'],
            [66, 'DWINY MEIDELFI, S.Kom, M.Cs', '0009058601', '198605092014042001', 'Perempuan', 7, 20, 'dwinymeidelfi@pnp.ac.id', '12345678', '', '1'],
            [85, 'ERVAN ASRI, S.Kom, M.Kom', '0001097802', '197809012008121001', 'Laki-laki', 7, 18, 'ervan@pnp.ac.id', '12345678', '', '1'],
            [91, 'FAZROL ROZI, M.Sc.', '0021078601', '19860721201012006', 'Laki-laki', 7, 19, 'fazrol@pnp.ac.id', '12345678', '', '1'],
            [103, 'FITRI NOVA, M.T, S.ST', '1029058502', '198505292014042001', 'Perempuan', 7, 19, 'fitrinova85@gmail.com', '12345678', '', '1'],
            [109, 'Ir. HANRIYAWAN ADNAN MOODUTO, M.Kom.', '0010056606', '196605101994031003', 'Laki-laki', 7, 19, 'mooduto@pnp.ac.id', '12345678', '', '1'],
            [116, 'HENDRICK, S.T, M.T.,Ph.D', '0002127705', '197712022006041000', 'Laki-laki', 4, 7, 'hendrickpnp77@gmail.com', '12345678', '', '1'],
            [121, 'HIDRA AMNUR, S.E., S.Kom, M.Kom', '0015048209', '198204152012121002', 'Laki-laki', 7, 18, 'hidra@pnp.ac.id', '12345678', '', '1'],
            [122, 'HUMAIRA, S.T, M.T', '0019038103', '198103192006042002', 'Perempuan', 7, 20, 'humaira@pnp.ac.id', '12345678', '', '1'],
            [127, 'IKHSAN YUSDA PRIMA PUTRA, S.H., LL.M', '0001107505', '197510012006041002', 'Laki-laki', 7, 19, '', '12345678', '', '1'],
            [132, 'INDRI RAHMAYUNI, S.T, M.T', '0025068301', '198306252008012004', 'Perempuan', 7, 20, 'indri@pnp.ac.id', '12345678', '', '1'],
            [160, 'MERI AZMI, S.T, M.Cs', '0029068102', '198106292006042001', 'Perempuan', 7, 18, 'meriazmi@gmail.com', '12345678', '', '1'],
            [198, 'Ir. Rahmat Hidayat, S.T, M.Sc.IT', '1015047801', '197804152000121002', 'Laki-laki', 7, 20, 'rahmat@pnp.ac.id', '12345678', '', '1'],
            [206, 'RASYIDAH, S.Si, M.M.', '0001067407', '197406012006042001', 'Perempuan', 7, 18, 'rasyidah@pnp.ac.id', '12345678', '', '1'],
            [212, 'RIKA IDMAYANTI, S.T, M.Kom', '0022017806', '197801222009122002', 'Perempuan', 7, 20, 'rikaidmayanti@pnp.ac.id', '12345678', '', '1'],
            [220, 'RITA AFYENNI, S.Kom, M.Kom', '0018077099', '197007182008012010', 'Perempuan', 7, 18, 'ritaafyenni@pnp.ac.id', '12345678', '', '1'],
            [223, 'RONAL HADI, S.T, M.Kom', '0029017603', '197601292002121001', 'Laki-laki', 7, 19, 'ronalhadi@pnp.ac.id', '12345678', '', '1'],
            [258, 'TAUFIK GUSMAN,  S.S.T, M.Ds', '0010088805', ' 19880810 201903 1 012', 'Laki-laki', 7, 18, 'taufikgusman@gmail.com', '12345678', '', '1'],
            [277, 'YANCE SONATHA, S.Kom, M.T', '0029128003', '198012292006042001', 'Perempuan', 7, 18, 'sonatha.yance@gmail.com', '12345678', '', '1'],
            [289, 'Dr. Ir. YUHEFIZAR, S.Kom., M.Kom', '0013017604', '197601132006041002', 'Laki-laki', 7, 18, 'yuhefizar@pnp.ac.id', '12345678', '', '1'],
            [292, 'YULHERNIWATI, S.Kom, M.T', '0019077609', '197607192008012017', 'Perempuan', 7, 20, 'yulherniwati@pnp.ac.id', '12345678', '', '1'],
            [310, 'TRI LESTARI, S.Pd.,M.Eng.', '0005039205', '199203052019032025', 'Perempuan', 7, 18, 'trilestari0503@gmail.com', '12345678', '', '1'],
            [311, 'Fanni Sukma, S.ST., M.T', '0006069009', '199006062019032026', 'Perempuan', 7, 20, 'fannisukma@pnp.ac.id', '12345678', '', '1'],
            [312, 'Andre Febrian Kasmar, S.T., M.T.', '0020028804', '198802202019031009', 'Laki-laki', 7, 20, 'andrefebrian@pnp.ac.id', '12345678', '', '1'],
            [351, 'RONI PUTRA, S.Kom, M.T ', '0022078607', '198607222009121004', 'Laki-laki', 7, 18, 'rn.putra@gmail.com', '12345678', '', '1'],
            [352, 'Ardi Syawaldipa, S.Kom.,M.T.', '0029058909', '19890529 202012 1 003', 'Laki-laki', 7, 19, 'ardi.syawaldipa@gmail.com', '12345678', '', '1'],
            [353, 'Harfebi Fryonanda, S.Kom., M.Kom', '0310119101', '19911110 202203 1 008', 'Laki-laki', 7, 20, 'harfebi@pnp.ac.id', '12345678', '', '1'],
            [354, 'Ideva Gaputra, S.Kom., M.Kom', '0012098808', '198809122022031006', 'Laki-laki', 7, 19, 'idevagaputra@pnp.ac.id', '12345678', '', '1'],
            [355, 'Yulia Jihan Sy, S.Kom., M.Kom', '1017078904', '19890717 202203 2 010', 'Perempuan', 7, 19, 'yulia@pnp.ac.id', '12345678', '', '1'],
            [356, 'Andrew Kurniawan Vadreas, S.Kom., M.T ', '1021028702', '19870221 202203 1 001', 'Laki-laki', 7, 18, 'andrew@pnp.ac.id', '12345678', '', '1'],
            [357, 'YORI ADI ATMA, S.Pd., M.Kom', '2010059001', '19900510 202203 1 002', 'Laki-laki', 7, 18, 'yori@pnp.ac.id', '12345678', '', '1'],
            [358, 'Dr. Ulya Ilhami Arsyah, S.Kom., M.Kom', '0130039101', '19910330 202203 1 004', 'Laki-laki', 7, 20, 'ulya@pnp.ac.id', '12345678', '', '1'],
            [359, 'Hendra Rotama, S.Pd., M.Sn', '0218068801', '19880618 202203 1 003', 'Laki-laki', 7, 19, 'hendrarotama@pnp.ac.id', '12345678', '', '1'],
            [360, 'Sumema, S.Ds., M.Ds', '0008069103', '19910608 202203 2 006', 'Perempuan', 7, 19, 'sumema@pnp.ac.id', '12345678', '', '1'],
            [361, 'Raemon Syaljumairi, S.Kom., M.Kom', '0017078407', '19840717 201012 1 002', 'Laki-laki', 7, 19, 'raemon_syaljumairi@pnp.ac.id', '12345678', '', '1'],
            [362, 'Mutia Rahmi Dewi, S.Kom., M.Kom', '0004099601', '19960904 202203 2 018', 'Perempuan', 7, 20, 'mutiarahmi@pnp.ac.id', '12345678', '', '1'],
            [363, 'Novi, S.Kom., M.T', '0001118611', '19861101 202203 2 003', 'Perempuan', 7, 19, 'novi@pnp.ac.id', '12345678', '', '1'],
            [364, 'Rahmi Putri Kurnia, S.Kom., M.Kom', '0027089303', '19930827 202203 2 012', 'Perempuan', 7, 19, 'rahmiputri@pnp.ac.id', '12345678', '', '1']
        ];

        foreach ($dosenData as $data) {
            DB::table('dosen')->insert([
                'id_dosen' => $data[0],
                'nama_dosen' => $data[1],
                'nidn' => $data[2],
                'nip' => $data[3],
                'gender' => $data[4],
                'jurusan_id' => $data[5],
                'prodi_id' => $data[6],
                'email' => $data[7],
                'password' => $data[8],
                'image' => $data[9],
                'status_dosen' => $data[10]
            ]);
        }
    }
}
