// AI Chatbot functionality
class MoodFoodChatbot {
    constructor() {
        this.responses = {
            greetings: [
                "Halo! Saya di sini untuk membantu Anda dengan rekomendasi makanan berdasarkan mood. Bagaimana perasaan Anda hari ini?",
                "Selamat datang di MoodFood Pro! Ceritakan mood Anda dan saya akan memberikan saran makanan yang tepat.",
                "Hai! Saya asisten nutrisi AI Anda. Mari kita temukan makanan yang cocok dengan mood Anda!"
            ],
            mood_questions: [
                "Interesting! Bisa Anda ceritakan lebih detail tentang perasaan Anda?",
                "Saya mengerti. Apakah ada situasi khusus yang membuat Anda merasa seperti ini?",
                "Terima kasih sudah berbagi. Apakah Anda ingin rekomendasi makanan untuk mood ini?"
            ],
            food_suggestions: {
                sedih: [
                    "Untuk mood sedih, saya rekomendasikan makanan kaya triptofan seperti pisang atau dark chocolate. Ini dapat membantu meningkatkan produksi serotonin.",
                    "Cobalah salmon yang kaya omega-3 atau bayam yang tinggi folat. Keduanya bagus untuk meningkatkan mood.",
                    "Smoothie pisang-berry bisa jadi pilihan yang menyegarkan dan bergizi untuk hari yang sedih."
                ],
                senang: [
                    "Pertahankan mood positif Anda dengan alpukat atau kacang almond! Kedua makanan ini memberikan energi berkelanjutan.",
                    "Avocado toast bisa jadi pilihan sempurna untuk menjaga mood bahagia Anda tetap stabil.",
                    "Saat senang, pilihlah makanan yang mendukung energi stabil seperti alpukat dan kacang-kacangan."
                ],
                marah: [
                    "Untuk menenangkan emosi, cobalah teh hijau dengan L-theanine atau yogurt dengan probiotik.",
                    "Golden milk dengan kunyit dan jahe dapat membantu meredakan perasaan marah secara alami.",
                    "Hindari kafein berlebihan saat marah. Pilihlah chamomile tea atau herbal tea yang menenangkan."
                ],
                cemas: [
                    "Untuk mengurangi kecemasan, saya sarankan chamomile tea dan ikan tuna yang kaya omega-3.",
                    "Makanan anti-inflamasi seperti kunyit dan jahe dapat membantu menenangkan sistem saraf.",
                    "Hindari gula berlebihan yang bisa memperburuk kecemasan. Pilihlah protein berkualitas tinggi."
                ],
                stress: [
                    "Blueberry dan oatmeal adalah kombinasi sempurna untuk melawan stress dengan antioksidan dan karbohidrat kompleks.",
                    "Magnesium dalam kacang almond dapat membantu mengurangi tingkat stress Anda.",
                    "Green tea dan dark chocolate (dalam porsi sedang) dapat membantu mengelola stress."
                ],
                lelah: [
                    "Untuk mengatasi kelelahan, kombinasikan protein berkualitas tinggi seperti telur dengan kopi untuk energi berkelanjutan.",
                    "Acai bowl dengan granola dan buah-buahan segar dapat memberikan energi natural yang Anda butuhkan.",
                    "Pastikan Anda cukup hidrasi dan konsumsi protein untuk mengatasi kelelahan."
                ]
            },
            nutrition_tips: [
                "💡 Tip: Minum air putih yang cukup dapat membantu menjaga mood stabil sepanjang hari.",
                "🥗 Kombinasikan protein, karbohidrat kompleks, dan lemak sehat dalam setiap makanan untuk energi optimal.",
                "🌿 Herbal seperti chamomile, lavender, dan lemon balm memiliki efek menenangkan alami.",
                "🍎 Buah dan sayur berwarna-warni mengandung antioksidan yang baik untuk kesehatan mental.",
                "🥜 Kacang-kacangan dan biji-bijian adalah sumber magnesium yang bagus untuk mengurangi stress."
            ],
            fallback: [
                "Maaf, saya tidak sepenuhnya memahami. Bisakah Anda menceritakan lebih detail tentang mood atau makanan yang Anda inginkan?",
                "Saya di sini untuk membantu dengan rekomendasi makanan berdasarkan mood. Coba katakan mood Anda seperti 'sedih', 'senang', atau 'stress'.",
                "Mari fokus pada mood dan makanan. Bagaimana perasaan Anda hari ini? Saya akan berikan rekomendasi yang tepat."
            ]
        };

        this.conversationHistory = [];
        this.currentMood = null;
        this.init();
    }

    init() {
        this.addEventListeners();
        this.addWelcomeMessage();
    }    addEventListeners() {
        const chatInput = document.getElementById('chatInput');
        const sendButton = document.querySelector('.chatbot-input button');

        if (chatInput) {
            chatInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    this.sendMessage();
                }
            });
        }

        if (sendButton) {
            sendButton.addEventListener('click', () => {
                this.sendMessage();
            });
        }
    }

    sendMessage() {
        const input = document.getElementById('chatInput');
        const message = input.value.trim();

        if (!message) return;

        // Add user message
        this.addMessage(message, 'user');
        
        // Clear input
        input.value = '';

        // Show typing indicator
        this.showTypingIndicator();

        // Generate response
        setTimeout(() => {
            this.hideTypingIndicator();
            const response = this.generateResponse(message);
            this.addMessage(response, 'bot');
        }, 1000 + Math.random() * 2000); // Random delay for more natural feel
    }    addMessage(text, sender) {
        const messagesContainer = document.getElementById('chatMessages');
        if (!messagesContainer) return;

        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${sender}`;
        messageDiv.textContent = text;

        messagesContainer.appendChild(messageDiv);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;

        // Save to conversation history
        this.conversationHistory.push({ text, sender, timestamp: new Date() });
    }

    showTypingIndicator() {
        const messagesContainer = document.getElementById('chatMessages');
        if (!messagesContainer) return;

        const typingDiv = document.createElement('div');
        typingDiv.className = 'message bot typing-indicator';
        typingDiv.innerHTML = `
            <div class="typing-dot"></div>
            <div class="typing-dot"></div>
            <div class="typing-dot"></div>
        `;
        typingDiv.id = 'typing-indicator';

        messagesContainer.appendChild(typingDiv);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    hideTypingIndicator() {
        const typingIndicator = document.getElementById('typing-indicator');
        if (typingIndicator) {
            typingIndicator.remove();
        }
    }

    generateResponse(userMessage) {
        const message = userMessage.toLowerCase();
        
        // Check for greetings
        if (this.isGreeting(message)) {
            return this.getRandomResponse(this.responses.greetings);
        }

        // Check for mood keywords
        const detectedMood = this.detectMood(message);
        if (detectedMood) {
            this.currentMood = detectedMood;
            
            // Update app mood if available
            if (window.app) {
                window.app.selectMood(detectedMood);
            }
            
            return this.getMoodResponse(detectedMood);
        }

        // Check for food-related questions
        if (this.isFoodQuestion(message)) {
            if (this.currentMood) {
                return this.getFoodSuggestion(this.currentMood);
            } else {
                return "Untuk memberikan rekomendasi makanan yang tepat, bisakah Anda ceritakan mood Anda terlebih dahulu?";
            }
        }

        // Check for nutrition questions
        if (this.isNutritionQuestion(message)) {
            return this.getRandomResponse(this.responses.nutrition_tips);
        }

        // Check for specific recipe requests
        if (message.includes('resep') || message.includes('recipe')) {
            return this.getRecipeResponse();
        }

        // Check for help requests
        if (message.includes('help') || message.includes('bantuan')) {
            return this.getHelpResponse();
        }

        // Default fallback
        return this.getRandomResponse(this.responses.fallback);
    }

    isGreeting(message) {
        const greetingKeywords = ['halo', 'hai', 'hello', 'hi', 'selamat', 'good'];
        return greetingKeywords.some(keyword => message.includes(keyword));
    }

    detectMood(message) {
        const moodKeywords = {
            sedih: ['sedih', 'sad', 'down', 'depresi', 'murung', 'galau'],
            bahagia: ['bahagia', 'senang', 'happy', 'gembira', 'ceria', 'riang'],
            marah: ['marah', 'angry', 'kesal', 'emosi', 'jengkel', 'bete'],
            cemas: ['cemas', 'anxious', 'khawatir', 'nervous', 'gelisah', 'takut'],
            stress: ['stress', 'stres', 'tertekan', 'overwhelmed', 'capek mental'],
            lelah: ['lelah', 'tired', 'capek', 'exhausted', 'ngantuk', 'lemas']
        };

        for (const [mood, keywords] of Object.entries(moodKeywords)) {
            if (keywords.some(keyword => message.toLowerCase().includes(keyword))) {
                return mood;
            }
        }
        return null;
    }

    getMoodResponse(mood) {
        const suggestions = this.responses.food_suggestions[mood];
        if (suggestions) {
            return this.getRandomResponse(suggestions);
        }
        return `Saya mengerti Anda merasa ${mood}. Mari saya bantu dengan rekomendasi makanan yang tepat.`;
    }

    isFoodQuestion(message) {
        const foodKeywords = ['makanan', 'makan', 'food', 'eat', 'resep', 'recipe', 'nutrisi', 'nutrition'];
        return foodKeywords.some(keyword => message.toLowerCase().includes(keyword));
    }

    isNutritionQuestion(message) {
        const nutritionKeywords = ['vitamin', 'protein', 'nutrisi', 'sehat', 'healthy', 'gizi', 'kalori'];
        return nutritionKeywords.some(keyword => message.toLowerCase().includes(keyword));
    }

    getFoodSuggestion(mood) {
        const suggestions = this.responses.food_suggestions[mood];
        if (suggestions && suggestions.length > 0) {
            return this.getRandomResponse(suggestions);
        }
        return `Untuk mood ${mood}, saya sarankan makanan yang kaya nutrisi dan dapat membantu memperbaiki suasana hati Anda.`;
    }

    getRecipeResponse() {
        if (this.currentMood) {
            return `Untuk mood ${this.currentMood}, saya dapat memberikan beberapa resep yang cocok. Silakan cek bagian Smart Recipes di aplikasi untuk resep lengkap.`;
        }
        return "Untuk memberikan resep yang tepat, ceritakan dulu mood Anda hari ini.";
    }

    getHelpResponse() {
        return `Saya bisa membantu Anda dengan:
        
• Rekomendasi makanan berdasarkan mood
• Tips nutrisi untuk kesehatan mental
• Saran resep yang sesuai dengan perasaan Anda
• Informasi tentang hubungan makanan dan mood

Coba ceritakan mood Anda atau tanyakan tentang makanan tertentu!`;
    }

    getRandomResponse(responses) {
        if (!Array.isArray(responses) || responses.length === 0) {
            return "Maaf, saya tidak memiliki respons yang tepat saat ini.";
        }
        return responses[Math.floor(Math.random() * responses.length)];
    }

    addWelcomeMessage() {
        setTimeout(() => {
            this.addMessage(this.getRandomResponse(this.responses.greetings), 'bot');
        }, 1000);
    }

    // Method to integrate with main app
    setMood(mood) {
        this.currentMood = mood;
        const response = `Saya lihat Anda memilih mood "${mood}". ${this.getMoodResponse(mood)}`;
        this.addMessage(response, 'bot');
    }

    // Clear conversation history
    clearConversation() {
        const messagesContainer = document.querySelector('.chatbot-messages');
        if (messagesContainer) {
            messagesContainer.innerHTML = '';
        }
        this.conversationHistory = [];
        this.currentMood = null;
        this.addWelcomeMessage();
    }

    // Export conversation for analysis
    exportConversation() {
        return {
            history: this.conversationHistory,
            currentMood: this.currentMood,
            timestamp: new Date().toISOString()
        };
    }

    toggleChatbot() {
        const chatbot = document.getElementById('chatbot');
        if (chatbot) {
            const isVisible = chatbot.style.display === 'flex';
            chatbot.style.display = isVisible ? 'none' : 'flex';
            
            // Add animation classes
            if (!isVisible) {
                chatbot.classList.add('chatbot-open');
                chatbot.classList.remove('chatbot-closed');
            } else {
                chatbot.classList.add('chatbot-closed');
                chatbot.classList.remove('chatbot-open');
            }
        }
    }

    handleKeyPress(event) {
        if (event.key === 'Enter') {
            this.sendMessage();
        }
    }

    addWelcomeMessage() {
        const welcomeMessage = this.responses.greetings[0];
        setTimeout(() => {
            this.addMessage(welcomeMessage, 'bot');
        }, 500);
    }

    setMood(mood) {
        this.currentMood = mood;
        // Optionally send a contextual message about the mood
        const moodMessage = `Saya melihat Anda merasa ${mood}. Mari saya bantu dengan rekomendasi makanan yang tepat.`;
        this.addMessage(moodMessage, 'bot');
    }
}

// Initialize chatbot only if not already initialized by main app
document.addEventListener('DOMContentLoaded', () => {
    if (!window.chatbot && !window.moodFoodApp) {
        window.chatbot = new MoodFoodChatbot();
    }
    
    // Listen for mood changes from main app
    document.addEventListener('moodChanged', (event) => {
        if (window.chatbot) {
            window.chatbot.setMood(event.detail.mood);
        }
    });
});

// Export for use in other modules
if (typeof module !== 'undefined' && module.exports) {
    module.exports = MoodFoodChatbot;
}
