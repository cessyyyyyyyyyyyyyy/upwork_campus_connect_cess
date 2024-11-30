document.addEventListener('DOMContentLoaded', () => {
  const reviewForm = document.querySelector('form')
  const reviewsContainer = document.getElementById('reviewsContainer')

  // Submit review
  reviewForm.addEventListener('submit', async (e) => {
    e.preventDefault()
    const formData = new FormData(reviewForm)

    try {
      const response = await fetch('../includes/submit_review.php', {
        method: 'POST',
        body: formData,
      })
      const data = await response.json()
      alert(data.message)
      if (response.ok) {
        reviewForm.reset()
        loadReviews() // Refresh reviews
      }
    } catch (error) {
      console.error('Error submitting review:', error)
    }
  })

  // Load reviews
  async function loadReviews() {
    try {
      const response = await fetch('../includes/fetch_reviews.php')
      const reviews = await response.json()
      reviewsContainer.innerHTML = reviews.length
        ? reviews
            .map(
              (review) => `
            <div class="col">
              <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                  <p class="card-title fw-bold">Review by ${
                    review.reviewer_name
                  }</p>
                  <div class="mb-2">${'★'.repeat(review.rating)}${'☆'.repeat(
                5 - review.rating
              )}</div>
                  <p class="card-text">${review.comment}</p>
                </div>
              </div>
            </div>
            `
            )
            .join('')
        : '<p>No reviews yet. Be the first to leave one!</p>'
    } catch (error) {
      console.error('Error loading reviews:', error)
    }
  }

  loadReviews()
})
