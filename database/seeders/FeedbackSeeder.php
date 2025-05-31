<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Feedback;
use Carbon\Carbon;

class FeedbackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $feedbacks = [
            [
                'name' => 'Sarah Putri',
                'email' => 'sarah.putri@gmail.com',
                'message' => 'MoodFood benar-benar mengubah hidup saya! Saya yang biasanya bingung mau makan apa saat sedih, sekarang punya panduan yang tepat. Rekomendasi dark chocolate oatmeal-nya luar biasa membantu mood saya. Terima kasih MoodFood! ⭐⭐⭐⭐⭐',
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDays(2),
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@yahoo.com',
                'message' => 'Aplikasi yang sangat membantu! Sebagai pekerja kantoran yang sering stres, MoodFood memberikan rekomendasi makanan yang tepat untuk menenangkan pikiran. Salmon panggang dengan asparagus yang direkomendasikan untuk mood cemas benar-benar efektif. Sangat direkomendasikan! 👍',
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(3),
            ],
            [
                'name' => 'Dewi Kusuma',
                'email' => 'dewi.kusuma@hotmail.com',
                'message' => 'Sangat terkesan dengan sistem rekomendasi MoodFood! Interface-nya user-friendly dan rekomendasi makanannya akurat. Ketika saya merasa lelah setelah bekerja, aplikasi ini merekomendasikan smoothie bowl yang tepat untuk mengembalikan energi. Love it! 💚',
                'created_at' => Carbon::now()->subDays(1),
                'updated_at' => Carbon::now()->subDays(1),
            ],
            [
                'name' => 'Ahmad Rizky',
                'email' => 'ahmad.rizky@gmail.com',
                'message' => 'Konsep yang brilliant! Sebagai mahasiswa yang sering merasa cemas menghadapi ujian, MoodFood membantu saya menemukan makanan yang tepat untuk menenangkan diri. Tips nutrisi berdasarkan mood-nya juga sangat edukatif. Terima kasih telah menciptakan aplikasi yang sangat bermanfaat ini! 🎓',
                'created_at' => Carbon::now()->subHours(6),
                'updated_at' => Carbon::now()->subHours(6),
            ],
            [
                'name' => 'Rina Maharani',
                'email' => 'rina.maharani@outlook.com',
                'message' => 'MoodFood adalah game changer untuk saya yang sering mengalami mood swing. Aplikasi ini tidak hanya memberikan rekomendasi makanan, tapi juga edukasi tentang hubungan antara nutrisi dan emosi. Fitur avatar dan rating sistemnya juga menarik. Highly recommended! 🌟',
                'created_at' => Carbon::now()->subHours(3),
                'updated_at' => Carbon::now()->subHours(3),
            ],
            [
                'name' => 'Fajar Pratama',
                'email' => 'fajar.pratama@gmail.com',
                'message' => 'Aplikasi yang inovatif! Sebagai food blogger, saya kagum dengan pendekatan MoodFood yang menghubungkan emosi dengan nutrisi. Rekomendasi makanan berdasarkan mood benar-benar membantu meningkatkan kualitas hidup sehari-hari. Great job! 📝✨',
                'created_at' => Carbon::now()->subHours(12),
                'updated_at' => Carbon::now()->subHours(12),
            ],
            [
                'name' => 'Maya Sari',
                'email' => 'maya.sari@yahoo.com',
                'message' => 'Luar biasa! MoodFood membantu saya memahami pola makan yang sehat berdasarkan perasaan. Ketika saya merasa down, rekomendasi makanan kaya serotonin seperti pisang dan coklat hitam benar-benar membantu. UI/UX-nya juga sangat menarik! 🍌🍫',
                'created_at' => Carbon::now()->subDays(4),
                'updated_at' => Carbon::now()->subDays(4),
            ],
            [
                'name' => 'Rendi Kurniawan',
                'email' => 'rendi.kurniawan@gmail.com',
                'message' => 'Sebagai seorang chef, saya appreciate banget konsep MoodFood. Aplikasi ini memberikan insight baru tentang bagaimana makanan bisa mempengaruhi mood dan sebaliknya. Sangat membantu dalam menciptakan menu yang tidak hanya lezat tapi juga bermanfaat untuk kesehatan mental. 👨‍🍳',
                'created_at' => Carbon::now()->subDays(5),
                'updated_at' => Carbon::now()->subDays(5),
            ],
            [
                'name' => 'Sinta Permata',
                'email' => 'sinta.permata@hotmail.com',
                'message' => 'MoodFood sangat membantu saya sebagai working mom yang sering merasa overwhelmed. Rekomendasi makanan yang mudah dibuat tapi bergizi tinggi sangat praktis. Anak-anak juga suka dengan menu sehat yang disarankan. Thank you MoodFood! 👩‍👧‍👦❤️',
                'created_at' => Carbon::now()->subDays(6),
                'updated_at' => Carbon::now()->subDays(6),
            ],
            [
                'name' => 'Kevin Hartanto',
                'email' => 'kevin.hartanto@outlook.com',
                'message' => 'Aplikasi yang sangat inovatif! Sebagai seseorang yang peduli dengan wellness, MoodFood memberikan pendekatan holistik terhadap kesehatan. Kombinasi antara teknologi dan nutrisi science-nya impressive. Fitur mood tracking-nya juga sangat helpful untuk self-awareness. 🧠💪',
                'created_at' => Carbon::now()->subDays(7),
                'updated_at' => Carbon::now()->subDays(7),
            ],
            [
                'name' => 'Alicia Rahman',
                'email' => 'alicia.rahman@gmail.com',
                'message' => 'Amazing app! MoodFood membantu saya mengembangkan relationship yang lebih sehat dengan makanan. Sekarang saya lebih mindful dalam memilih makanan berdasarkan kebutuhan emosional. The science behind it is fascinating! 🔬✨',
                'created_at' => Carbon::now()->subDays(8),
                'updated_at' => Carbon::now()->subDays(8),
            ],
            [
                'name' => 'Dimas Prasetyo',
                'email' => 'dimas.prasetyo@yahoo.com',
                'message' => 'Sebagai atlet, saya sangat terbantu dengan rekomendasi MoodFood untuk pre dan post workout meals yang bisa boost mood dan performance. Aplikasi ini benar-benar comprehensive dan evidence-based. Kudos to the team! 🏃‍♂️💯',
                'created_at' => Carbon::now()->subDays(9),
                'updated_at' => Carbon::now()->subDays(9),
            ]
        ];

        foreach ($feedbacks as $feedback) {
            Feedback::create($feedback);
        }
    }
}
