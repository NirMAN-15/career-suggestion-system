// Assessment Logic
let currentQuestionIndex = 0;
let questions = [];
let userAnswers = {};

// DOM Elements
const questionContainer = document.getElementById('questionContainer');
const questionTitle = document.getElementById('questionTitle');
const questionNumber = document.getElementById('questionNumber');
const optionsContainer = document.getElementById('optionsContainer');
const prevBtn = document.getElementById('prevBtn');
const nextBtn = document.getElementById('nextBtn');
const submitBtn = document.getElementById('submitBtn');
const progressFill = document.getElementById('progressFill');
const currentQuestionSpan = document.getElementById('currentQuestion');
const totalQuestionsSpan = document.getElementById('totalQuestions');
const progressPercentage = document.getElementById('progressPercentage');
const assessmentCard = document.getElementById('assessmentCard');
const completionCard = document.getElementById('completionCard');

// Initialize Assessment
document.addEventListener('DOMContentLoaded', function() {
    loadQuestions();
    setupEventListeners();
    checkSavedProgress();
});

// Load Questions from API
function loadQuestions() {
    showLoader();
    
    fetch('api/get_questions.php')
        .then(response => response.json())
        .then(data => {
            hideLoader();
            if(data.success) {
                questions = data.questions;
                totalQuestionsSpan.textContent = questions.length;
                displayQuestion(currentQuestionIndex);
            } else {
                alert('Error loading questions: ' + data.message);
            }
        })
        .catch(error => {
            hideLoader();
            console.error('Error:', error);
            alert('Failed to load questions. Please refresh the page.');
        });
}

// Display Question
function displayQuestion(index) {
    if(index < 0 || index >= questions.length) return;
    
    const question = questions[index];
    
    // Update question display
    questionNumber.textContent = `Question ${index + 1} of ${questions.length}`;
    questionTitle.textContent = question.question_text;
    currentQuestionSpan.textContent = index + 1;
    
    // Clear and populate options
    optionsContainer.innerHTML = '';
    
    const options = JSON.parse(question.options);
    options.forEach((option, optIndex) => {
        const optionBtn = document.createElement('button');
        optionBtn.className = 'option-btn';
        optionBtn.setAttribute('data-value', option);
        
        // Check if this option was previously selected
        if(userAnswers[question.question_id] === option) {
            optionBtn.classList.add('selected');
        }
        
        optionBtn.innerHTML = `
            <span class="option-icon">
                <i class="fas fa-circle"></i>
            </span>
            <span class="option-text">${option}</span>
        `;
        
        optionBtn.addEventListener('click', function() {
            selectOption(question.question_id, option, optionBtn);
        });
        
        optionsContainer.appendChild(optionBtn);
    });
    
    // Update progress
    updateProgress();
    
    // Update button visibility
    updateButtonVisibility();
}

// Select Option
function selectOption(questionId, value, button) {
    // Remove 'selected' class from all options
    const allOptions = optionsContainer.querySelectorAll('.option-btn');
    allOptions.forEach(opt => opt.classList.remove('selected'));
    
    // Add 'selected' class to clicked option
    button.classList.add('selected');
    
    // Save answer
    userAnswers[questionId] = value;
    
    // Enable next button
    nextBtn.disabled = false;
    
    // Auto-save progress
    saveProgress();
    
    // Show save indicator
    showSaveIndicator();
}

// Update Progress Bar
function updateProgress() {
    const answeredCount = Object.keys(userAnswers).length;
    const percentage = Math.round((answeredCount / questions.length) * 100);
    
    progressFill.style.width = percentage + '%';
    progressPercentage.textContent = percentage;
}

// Update Button Visibility
function updateButtonVisibility() {
    // Previous button
    prevBtn.style.display = currentQuestionIndex > 0 ? 'inline-block' : 'none';
    
    // Check if current question is answered
    const currentQuestion = questions[currentQuestionIndex];
    const isAnswered = userAnswers[currentQuestion.question_id] !== undefined;
    
    // Next/Submit button
    if(currentQuestionIndex === questions.length - 1) {
        nextBtn.style.display = 'none';
        submitBtn.style.display = 'inline-block';
        submitBtn.disabled = !isAnswered;
    } else {
        nextBtn.style.display = 'inline-block';
        submitBtn.style.display = 'none';
        nextBtn.disabled = !isAnswered;
    }
}

// Navigation Functions
function nextQuestion() {
    if(currentQuestionIndex < questions.length - 1) {
        currentQuestionIndex++;
        displayQuestion(currentQuestionIndex);
    }
}

function previousQuestion() {
    if(currentQuestionIndex > 0) {
        currentQuestionIndex--;
        displayQuestion(currentQuestionIndex);
    }
}

// Setup Event Listeners
function setupEventListeners() {
    nextBtn.addEventListener('click', nextQuestion);
    prevBtn.addEventListener('click', previousQuestion);
    submitBtn.addEventListener('click', submitAssessment);
}

// Submit Assessment
function submitAssessment() {
    // Check if all questions are answered
    if(Object.keys(userAnswers).length < questions.length) {
        alert('Please answer all questions before submitting.');
        return;
    }
    
    if(!confirm('Are you sure you want to submit your assessment? You cannot change your answers after submission.')) {
        return;
    }
    
    showLoader();
    
    // Prepare data
    const submissionData = {
        answers: userAnswers
    };
    
    // Submit to API
    fetch('api/submit_answers.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(submissionData)
    })
    .then(response => response.json())
    .then(data => {
        hideLoader();
        if(data.success) {
            // Show completion card
            assessmentCard.style.display = 'none';
            completionCard.style.display = 'block';
            
            // Redirect to results after 3 seconds
            setTimeout(() => {
                window.location.href = 'results.php';
            }, 3000);
        } else {
            alert('Error submitting assessment: ' + data.message);
        }
    })
    .catch(error => {
        hideLoader();
        console.error('Error:', error);
        alert('Failed to submit assessment. Please try again.');
    });
}

// Save Progress (Auto-save)
function saveProgress() {
    const progressData = {
        currentQuestion: currentQuestionIndex,
        answers: userAnswers
    };
    
    fetch('api/save_progress.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(progressData)
    })
    .catch(error => {
        console.error('Auto-save error:', error);
    });
}

// Check Saved Progress
function checkSavedProgress() {
    fetch('api/get_progress.php')
        .then(response => response.json())
        .then(data => {
            if(data.success && data.progress) {
                // Resume from saved progress
                currentQuestionIndex = data.progress.currentQuestion || 0;
                userAnswers = data.progress.answers || {};
                
                if(Object.keys(userAnswers).length > 0) {
                    // Show notification
                    if(confirm('Would you like to resume your previous assessment?')) {
                        displayQuestion(currentQuestionIndex);
                    } else {
                        // Clear progress and start fresh
                        userAnswers = {};
                        currentQuestionIndex = 0;
                        displayQuestion(currentQuestionIndex);
                    }
                }
            }
        })
        .catch(error => {
            console.error('Error checking progress:', error);
        });
}

// Show Save Indicator
function showSaveIndicator() {
    let indicator = document.querySelector('.save-indicator');
    
    if(!indicator) {
        indicator = document.createElement('div');
        indicator.className = 'save-indicator';
        indicator.innerHTML = '<i class="fas fa-check"></i> Progress Saved';
        document.body.appendChild(indicator);
    }
    
    indicator.classList.add('show');
    
    setTimeout(() => {
        indicator.classList.remove('show');
    }, 2000);
}