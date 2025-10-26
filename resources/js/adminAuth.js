export function adminAuth() {
  return {
    open: false,
    mode: 'login',
    loading: false,
    error: '',
    form: {
      email: '',
      fullname: '',
      username: '',
      password: '',
      password_confirmation: '',
      remember: false
    },
    toast: { show: false, message: '', type: 'success', progress: 100, duration: 3500 },

    // ✅ Single toast method
    showToast(msg, type = 'success') {
      this.toast.message = msg
      this.toast.type = type
      this.toast.show = true
      this.toast.progress = 100
      this.toast.duration = 3500

      this.$nextTick(() => {
        this.toast.progress = 0
      })

      setTimeout(() => {
        this.toast.show = false
      }, this.toast.duration)
    },

    init() {
      window.addEventListener('open-admin', () => {
        this.open = true
        this.$nextTick(() => {
          try {
            if (this.$refs?.adminEmail) this.$refs.adminEmail.focus()
          } catch (e) {}
        })
      })
    },

    async submit() {
      this.error = ''
      this.loading = true

      // ✅ Client-side checks
      if (this.mode === 'signup' && this.form.password.length < 6) {
        this.error = 'Password must be at least 6 characters'
        this.showToast(this.error, 'error')
        this.loading = false
        return
      }
      if (this.mode === 'signup' && this.form.password !== this.form.password_confirmation) {
        this.error = 'Passwords do not match'
        this.showToast(this.error, 'error')
        this.loading = false
        return
      }

      const url =
        this.mode === 'login'
          ? window.routes?.adminLogin ?? '/admin/login'
          : window.routes?.adminRegister ?? '/admin/register'

      const token = document.querySelector('meta[name="csrf-token"]').content

      try {
        const res = await fetch(url, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'X-Requested-With': 'XMLHttpRequest',
            Accept: 'application/json'
          },
          body: JSON.stringify(this.form),
          credentials: 'same-origin'
        })

        const payload = await res.json().catch(() => ({}))
        console.log('POST', url, res.status, payload)

        if (res.ok && payload.ok) {
          // ✅ Success
          this.form.password = ''
          this.form.password_confirmation = ''
          this.showToast(payload.message || 'Success', 'success')

          if (this.mode === 'signup') {
            this.mode = 'login'
            if (payload.email) this.form.email = payload.email
            this.$nextTick(() => this.$refs?.adminEmail?.focus())
          } else if (this.mode === 'login' && payload.redirect) {
            // ✅ Redirect after login
            window.location.href = payload.redirect
          }
          return
        }

        // ✅ Validation errors (422)
        if (res.status === 422 && payload?.errors) {
          const first = Object.values(payload.errors)[0]
          this.error = Array.isArray(first) ? first[0] : first
          this.showToast(this.error, 'error')
          // Notice: we do NOT close the modal here
          return
        }

        // ✅ Other errors
        this.error = payload?.raw || 'Request failed, check console'
        this.showToast(this.error, 'error')
      } catch (err) {
        console.error('submit error', err)
        this.error = 'Network or Server error'
        this.showToast(this.error, 'error')
      } finally {
        this.loading = false
      }
    }
  }
}