<?php

use Illuminate\Database\Seeder;

class HospitalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('patients')->insert([
          [ 'id_type' => '身分證', 'id_number' => 'F123456789', 'name' => '吳嘉豪', 'birthday' => '1983-05-17', 'gender' => 'M', 'phone' => '0988098311', 'address' => '台北市羅斯福路2段1號8樓' ],
          [ 'id_type' => '身分證', 'id_number' => 'F223456789', 'name' => '陳怡如', 'birthday' => '1984-06-18', 'gender' => 'F', 'phone' => '0988098312', 'address' => '台北市羅斯福路2段1號7樓' ],
          [ 'id_type' => '身分證', 'id_number' => 'F323456789', 'name' => '蔡歡怡', 'birthday' => '1985-07-19', 'gender' => 'M', 'phone' => '0988098313', 'address' => '台北市羅斯福路2段1號6樓' ],
          [ 'id_type' => '護照', 'id_number' => 'A4234567', 'name' => '陳晴映', 'birthday' => '1986-10-20', 'gender' => 'F', 'phone' => '0988098314', 'address' => '台北市羅斯福路2段1號5樓' ],
          [ 'id_type' => '護照', 'id_number' => 'X5234567', 'name' => '徐旻雯', 'birthday' => '1987-11-21', 'gender' => 'F', 'phone' => '0988098315', 'address' => '台北市羅斯福路2段1號4樓' ],
          [ 'id_type' => '護照', 'id_number' => 'A6234567', 'name' => '羅淑婷', 'birthday' => '1988-12-22', 'gender' => 'F', 'phone' => '0988098316', 'address' => '台北市羅斯福路2段1號3樓' ],
          [ 'id_type' => '居留證', 'id_number' => 'AC12345678', 'name' => '王旭枝', 'birthday' => '1989-08-23', 'gender' => 'M', 'phone' => '0988098317', 'address' => '台北市羅斯福路2段1號2樓' ],
          [ 'id_type' => '居留證', 'id_number' => 'AC22345678', 'name' => '林文馨', 'birthday' => '1990-09-24', 'gender' => 'F', 'phone' => '0988098318', 'address' => '台北市羅斯福路2段1號1樓' ],
          [ 'id_type' => '居留證', 'id_number' => 'AD32345678', 'name' => '楊育廷', 'birthday' => '1991-10-25', 'gender' => 'M', 'phone' => '0988098319', 'address' => '台北市羅斯福路2段1號9樓' ]
      ]);
      DB::table('medical_history_items')->insert([
          [ 'name' => '有無患過傳染病', 'unit' => '' ],
          [ 'name' => '有無預防接種', 'unit' => '' ],
          [ 'name' => '有無手術史', 'unit' => '' ],
          [ 'name' => '有無過敏的情況', 'unit' => '' ],
          [ 'name' => '有無慢性咳嗽、咳痰、咯血、胸痛、氣喘史等', 'unit' => '' ],
          [ 'name' => '有無心悸、氣促、紫紺、水腫、胸痛、昏厥、高血壓史等', 'unit' => '' ],
          [ 'name' => '有無食慾改變、暖氣、反酸、腹脹、腹痛、腹瀉、便秘、嘔血、黑便、黃疸史等', 'unit' => '' ],
          [ 'name' => '有無尿頻、尿急、尿痛、血尿、排 尿困難、腰痛、水腫史等', 'unit' => '' ],
          [ 'name' => '有無乏力、頭暈、皮膚或粘膜出血點、淤斑、反復鼻出血、牙齦出血史等', 'unit' => '' ],
          [ 'name' => '有無畏寒、怕熱、多汗、食慾異常、消瘦、口乾、多飲、多尿史，有無性格、體重、毛髮和第二性徵改變等', 'unit' => '' ],
          [ 'name' => '有無頭痛、眩暈、失眠、嗜睡、意識障礙、抽搐、癱瘓、驚厥、性格改變、視力障礙、感覺異常史等', 'unit' => '' ],
          [ 'name' => '有無肢體肌肉麻木、疼痛、痙孿、萎縮、癱瘓史，有無關節腫痛、運動障礙、外傷、骨折史等', 'unit' => '' ],
      ]);
      DB::table('departments')->insert([
          [ 'name' => '內科部' ],
          [ 'name' => '神經部' ],
          [ 'name' => '外科部' ],
          [ 'name' => '骨科部' ],
          [ 'name' => '眼科部' ],
          [ 'name' => '牙科部' ],
          [ 'name' => '皮膚部' ],
          [ 'name' => '耳鼻喉科' ]
      ]);
      DB::table('doctors')->insert([
          [ 'name' => '周文堅', 'department_id' => 1 ],
          [ 'name' => '郭炳宏', 'department_id' => 1 ],
          [ 'name' => '王振源', 'department_id' => 1 ],
          [ 'name' => '李銘仁', 'department_id' => 2 ],
          [ 'name' => '林靜嫻', 'department_id' => 2 ],
          [ 'name' => '潘明楷', 'department_id' => 2 ],
          [ 'name' => '陳柏達', 'department_id' => 3 ],
          [ 'name' => '張茂雄', 'department_id' => 3 ],
          [ 'name' => '陳坤源', 'department_id' => 3 ],
          [ 'name' => '劉堂桂', 'department_id' => 4 ],
          [ 'name' => '吳冠彣', 'department_id' => 4 ],
          [ 'name' => '李嘉哲', 'department_id' => 4 ],
          [ 'name' => '楊長豪', 'department_id' => 5 ],
          [ 'name' => '林昌平', 'department_id' => 5 ],
          [ 'name' => '王一中', 'department_id' => 5 ],
          [ 'name' => '王逸平', 'department_id' => 6 ],
          [ 'name' => '李正喆', 'department_id' => 6 ],
          [ 'name' => '姚宗珍', 'department_id' => 6 ],
          [ 'name' => '許郡安', 'department_id' => 7 ],
          [ 'name' => '張俊祥', 'department_id' => 7 ],
          [ 'name' => '柯玫如', 'department_id' => 7 ],
          [ 'name' => '烏惟新', 'department_id' => 8 ],
          [ 'name' => '陳柏樺', 'department_id' => 8 ],
          [ 'name' => '胡淑玲', 'department_id' => 8 ]
      ]);
      DB::table('rooms')->insert([
          [ 'room_bed' => '201-1', 'cost_per_day' => 800 ],
          [ 'room_bed' => '201-2', 'cost_per_day' => 800 ],
          [ 'room_bed' => '201-3', 'cost_per_day' => 800 ],
          [ 'room_bed' => '201-4', 'cost_per_day' => 800 ],
          [ 'room_bed' => '201-5', 'cost_per_day' => 800 ],
          [ 'room_bed' => '202-1', 'cost_per_day' => 800 ],
          [ 'room_bed' => '202-2', 'cost_per_day' => 800 ],
          [ 'room_bed' => '202-3', 'cost_per_day' => 800 ],
          [ 'room_bed' => '202-4', 'cost_per_day' => 800 ],
          [ 'room_bed' => '202-5', 'cost_per_day' => 800 ],
          [ 'room_bed' => '301-1', 'cost_per_day' => 1300 ],
          [ 'room_bed' => '301-2', 'cost_per_day' => 1300 ],
          [ 'room_bed' => '301-3', 'cost_per_day' => 1300 ],
          [ 'room_bed' => '302-1', 'cost_per_day' => 1300 ],
          [ 'room_bed' => '302-2', 'cost_per_day' => 1300 ],
          [ 'room_bed' => '303-3', 'cost_per_day' => 1300 ],
          [ 'room_bed' => '304-1', 'cost_per_day' => 1300 ],
          [ 'room_bed' => '304-2', 'cost_per_day' => 1300 ],
          [ 'room_bed' => '304-3', 'cost_per_day' => 1300 ],
          [ 'room_bed' => '305-1', 'cost_per_day' => 1300 ],
          [ 'room_bed' => '305-2', 'cost_per_day' => 1300 ],
          [ 'room_bed' => '305-3', 'cost_per_day' => 1300 ],
          [ 'room_bed' => '401-1', 'cost_per_day' => 4000 ],
          [ 'room_bed' => '402-1', 'cost_per_day' => 4000 ],
      ]);
      DB::table('treatment_categories')->insert([
          [ 'name' => '門診' ],
          [ 'name' => '藥品' ],
          [ 'name' => '住院' ],
          [ 'name' => '材科' ],
          [ 'name' => '其他' ]
      ]);
      DB::table('treatments')->insert([
          [ 'name' => '掛號', 'cost' => 250, 'category_id' => 1 ],
          [ 'name' => '醫師診察', 'cost' => 1000, 'category_id' => 1 ],
          [ 'name' => '藥品A', 'cost' => 100, 'category_id' => 2 ],
          [ 'name' => '藥品B', 'cost' => 200, 'category_id' => 2 ],
          [ 'name' => '藥品C', 'cost' => 300, 'category_id' => 2 ],
          [ 'name' => '藥品D', 'cost' => 400, 'category_id' => 2 ],
          [ 'name' => '護理', 'cost' => 1500, 'category_id' => 3 ],
          [ 'name' => '伙食A', 'cost' => 100, 'category_id' => 3 ],
          [ 'name' => '伙食B', 'cost' => 200, 'category_id' => 3 ],
          [ 'name' => '手術材料A', 'cost' => 1000, 'category_id' => 4 ],
          [ 'name' => '手術材料B', 'cost' => 5000, 'category_id' => 4 ],
          [ 'name' => '手術材料C', 'cost' => 9000, 'category_id' => 4 ],
      ]);
    }
}
