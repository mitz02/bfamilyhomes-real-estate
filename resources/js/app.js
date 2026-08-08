import "./bootstrap"

// Toast Notification System
window.toast = (message, type = "info", duration = 3000) => {
  const container = document.getElementById("toast-container") || createToastContainer()

  const toast = document.createElement("div")
  toast.className = `toast toast-${type}`

  const icon = getToastIcon(type)
  toast.innerHTML = `
        <i class="bi ${icon} text-xl"></i>
        <span>${message}</span>
    `

  container.appendChild(toast)

  // Force reflow to ensure initial state is applied
  toast.offsetHeight

  // Trigger slide-in animation with fade
  requestAnimationFrame(() => {
    requestAnimationFrame(() => {
      toast.style.transform = "translateX(0)"
      toast.style.opacity = "1"
    })
  })

  // Auto-remove after duration with smooth fade out
  setTimeout(() => {
    toast.style.transform = "translateX(150%)"
    toast.style.opacity = "0"
    setTimeout(() => {
      if (toast.parentNode) {
        toast.remove()
      }
    }, 400) // Match transition duration
  }, duration)
}

function createToastContainer() {
  const container = document.createElement("div")
  container.id = "toast-container"
  container.className = "toast-container"
  container.style.cssText = "position: fixed !important; top: 1rem !important; right: 1rem !important; z-index: 99999 !important; pointer-events: none; max-width: 400px; margin: 0 !important; padding: 0 !important;"
  document.body.appendChild(container)
  return container
}

function getToastIcon(type) {
  const icons = {
    success: "bi-check-circle-fill",
    error: "bi-x-circle-fill",
    warning: "bi-exclamation-triangle-fill",
    info: "bi-info-circle-fill",
  }
  return icons[type] || icons.info
}

// Loading Spinner - Unified loader function
window.showLoader = (element) => {
  if (!element) return
  const originalContent = element.innerHTML
  element.dataset.originalContent = originalContent
  element.disabled = true
  element.innerHTML = '<i class="bi bi-arrow-repeat animate-spin"></i> Loading...'
}

window.hideLoader = (element, originalText) => {
  if (!element) return
  element.disabled = false
  if (originalText) {
    element.innerHTML = originalText
  } else {
    element.innerHTML = element.dataset.originalContent || element.innerHTML
  }
}

// AJAX Helper with timeout and better error handling
const ajax = async (url, method = "GET", data = null, options = {}) => {
  // Create abort controller for timeout (if supported)
  let abortController = null
  let timeoutId = null
  
  // Set timeout for file uploads (5 minutes) or regular requests (30 seconds)
  const timeout = data instanceof FormData ? 300000 : 30000
  
  if (typeof AbortController !== 'undefined') {
    abortController = new AbortController()
    timeoutId = setTimeout(() => {
      if (abortController) {
        abortController.abort()
      }
    }, timeout)
  }

  const config = {
    method,
    headers: {
      "Content-Type": "application/json",
      "X-Requested-With": "XMLHttpRequest",
      "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.content,
    },
    signal: abortController ? abortController.signal : undefined,
    ...options,
  }

  if (data && method !== "GET") {
    if (data instanceof FormData) {
      delete config.headers["Content-Type"]
      config.body = data
    } else {
      config.body = JSON.stringify(data)
    }
  }

  try {
    const response = await fetch(url, config)
    
    // Clear timeout on successful response
    if (timeoutId) clearTimeout(timeoutId)
    
    // Check if response is JSON
    const contentType = response.headers.get("content-type")
    let result
    if (contentType && contentType.includes("application/json")) {
      result = await response.json()
    } else {
      // If not JSON, read as text
      const text = await response.text()
      try {
        result = JSON.parse(text)
      } catch {
        throw new Error(text || "Invalid response from server")
      }
    }

    if (!response.ok) {
      // Create error object with message and errors
      const error = new Error(result.message || "Request failed")
      error.errors = result.errors || {}
      error.response = result
      // Preserve the original error message if it exists
      if (result.message) {
        error.message = result.message
      }
      throw error
    }

    return result
  } catch (error) {
    // Clear timeout on error
    if (timeoutId) clearTimeout(timeoutId)
    
    // Handle timeout/abort errors
    if (error.name === 'AbortError' || error.name === 'TimeoutError') {
      const customError = new Error("Request timed out. Please try again with smaller files or check your connection.")
      customError.originalError = error
      throw customError
    }
    
    // Handle network errors
    if (error.message === 'Failed to fetch' || error.message.includes('ERR_CONNECTION') || error.message.includes('network')) {
      const customError = new Error("Network error. Please check your connection and try again. If uploading large files, they may exceed the server limit (max 5MB per file, 50MB total).")
      customError.originalError = error
      throw customError
    }
    
    // If it's already our custom error, just rethrow it
    if (error.errors || error.response) {
      throw error
    }
    // Otherwise, wrap it
    console.error("[v0] AJAX Error:", error)
    const customError = new Error(error.message || "Request failed")
    customError.originalError = error
    throw customError
  }
}

window.ajax = ajax

// Autocomplete for Property Search
window.initAutocomplete = (inputId, suggestionsId, fetchUrl) => {
  const input = document.getElementById(inputId)
  const suggestions = document.getElementById(suggestionsId)

  if (!input || !suggestions) return

  let timeout

  input.addEventListener("input", function () {
    clearTimeout(timeout)
    const query = this.value.trim()

    if (query.length < 2) {
      suggestions.innerHTML = ""
      suggestions.classList.add("hidden")
      return
    }

    timeout = setTimeout(async () => {
      try {
        const data = await window.ajax(`${fetchUrl}?q=${encodeURIComponent(query)}`)
        displaySuggestions(data.suggestions || [])
      } catch (error) {
        console.error("[v0] Autocomplete error:", error)
      }
    }, 300)
  })

  function displaySuggestions(items) {
    if (items.length === 0) {
      suggestions.innerHTML = ""
      suggestions.classList.add("hidden")
      return
    }

    suggestions.innerHTML = items
      .map(
        (item) => `
            <div class="p-3 hover:bg-gray-100 cursor-pointer" data-value="${item.value}">
                ${item.label}
            </div>
        `,
      )
      .join("")

    suggestions.classList.remove("hidden")

    suggestions.querySelectorAll("div").forEach((div) => {
      div.addEventListener("click", function () {
        input.value = this.dataset.value
        suggestions.innerHTML = ""
        suggestions.classList.add("hidden")
      })
    })
  }

  document.addEventListener("click", (e) => {
    if (!input.contains(e.target) && !suggestions.contains(e.target)) {
      suggestions.innerHTML = ""
      suggestions.classList.add("hidden")
    }
  })
}

// Sticky Header
window.addEventListener("scroll", () => {
  const header = document.getElementById("main-header")
  if (!header) return

  if (window.scrollY > 100) {
    header.classList.add("header-sticky")
  } else {
    header.classList.remove("header-sticky")
  }
})

// Image Preview for File Upload
window.previewImage = (input, previewId) => {
  const preview = document.getElementById(previewId)
  if (!input.files || !input.files[0] || !preview) return

  const reader = new FileReader()
  reader.onload = (e) => {
    preview.src = e.target.result
    preview.classList.remove("hidden")
  }
  reader.readAsDataURL(input.files[0])
}

// WhatsApp Integration
window.sendToWhatsApp = (phone, message) => {
  const url = `https://wa.me/${phone.replace(/[^0-9]/g, "")}?text=${encodeURIComponent(message)}`
  window.open(url, "_blank")
}

