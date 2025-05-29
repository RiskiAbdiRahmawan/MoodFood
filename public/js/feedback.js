// Feedback form functionality
document.addEventListener('DOMContentLoaded', function() {
    // Handle star rating selection
    const stars = document.querySelectorAll('.rating-stars .star');
    const ratingMessage = document.getElementById('rating-message');
    let selectedRating = 0;
    
    // Rating messages based on the star rating
    const ratingMessages = {
        1: "Maaf kami kurang membantu 😔",
        2: "Kami akan berusaha lebih baik 🙂",
        3: "Terima kasih atas penilaiannya 👍",
        4: "Senang bisa membantu Anda! 😊",
        5: "Luar biasa! Terima kasih banyak! 🌟"
    };
    
    stars.forEach(star => {
        star.addEventListener('mouseover', function() {
            const rating = parseInt(this.dataset.rating);
            highlightStars(rating);
            showRatingMessage(rating, true);
        });
        
        star.addEventListener('mouseout', function() {
            highlightStars(selectedRating);
            showRatingMessage(selectedRating, false);
        });
        
        star.addEventListener('click', function() {
            selectedRating = parseInt(this.dataset.rating);
            highlightStars(selectedRating);
            showRatingMessage(selectedRating, false);
            
            // Store the rating in the app if available
            if (window.moodFoodApp) {
                window.moodFoodApp.selectedRating = selectedRating;
            }
            
            // Add a nice animation effect
            stars.forEach(s => s.style.animation = '');
            this.style.animation = 'starPulse 0.6s ease-in-out';
            
            // Add success styles
            document.querySelector('.rating-container').classList.add('rating-selected');
        });
    });
    
    function highlightStars(rating) {
        stars.forEach(star => {
            const starRating = parseInt(star.dataset.rating);
            if (starRating <= rating) {
                star.classList.add('active');
            } else {
                star.classList.remove('active');
            }
        });
    }
    
    function showRatingMessage(rating, isHover) {
        if (rating > 0) {
            ratingMessage.textContent = ratingMessages[rating];
            ratingMessage.classList.add('visible');
            
            // Apply different styles for hover vs. selected
            if (isHover) {
                ratingMessage.classList.add('hover');
            } else {
                ratingMessage.classList.remove('hover');
            }
        } else {
            ratingMessage.classList.remove('visible');
        }
    }
    
    // Initialize the feedback form
    const feedbackForm = document.querySelector('.feedback-form');
    if (feedbackForm) {
        feedbackForm.addEventListener('submit', function(e) {
            e.preventDefault();
            if (window.submitFeedback) {
                window.submitFeedback();
            }
        });
    }
});

// Additional feedback animations
document.addEventListener('DOMContentLoaded', function() {
    const feedbackSection = document.querySelector('.feedback-section');
    
    if (feedbackSection) {
        // Add scroll into view animation
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.3
        });
        
        observer.observe(feedbackSection);
    }
    
    // Add submit feedback functionality
    window.submitFeedback = function() {
        const feedbackText = document.getElementById('feedback-text').value;
        const rating = window.moodFoodApp?.selectedRating || 0;
        
        if (rating === 0) {
            alert('Silakan berikan penilaian bintang terlebih dahulu');
            return;
        }
        
        // Here you would typically send the feedback to your server
        console.log('Submitting feedback:', {
            rating: rating,
            feedback: feedbackText
        });
        
        // Show thank you message
        const feedbackForm = document.querySelector('.feedback-form');
        const thankYouMessage = document.createElement('div');
        thankYouMessage.className = 'thank-you-message';
        thankYouMessage.innerHTML = `
            <i class="fas fa-check-circle"></i>
            <h3>Terima Kasih!</h3>
            <p>Feedback Anda sangat berarti untuk kami.</p>
        `;
        
        // Animate form out and thank you message in
        feedbackForm.style.animation = 'fadeOutDown 0.5s forwards';
        setTimeout(() => {
            feedbackForm.parentNode.replaceChild(thankYouMessage, feedbackForm);
            thankYouMessage.style.animation = 'fadeInUp 0.5s forwards';
        }, 500);
    };
});
