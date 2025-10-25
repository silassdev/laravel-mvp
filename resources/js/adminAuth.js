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
    toast: { show: false, message: '' },

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

    showToast(msg) {
      this.toast.message = msg
      this.toast.show = true
      setTimeout(() => (this.toast.show = false), 3500)
    },

    async submit() {
      this.error = ''

      // basic validation
      if (this.mode === 'signup' && this.form.password.length < 6) {
        this.error = 'Password must be at least 6 characters'
        return
      }
      if (
        this.mode === 'signup' &&
        this.form.password !== this.form.password_confirmation
      ) {
        this.error = 'Passwords do not match'
        return
      }

      const url =
        this.mode === 'login'
          ? window.routes?.adminLogin ?? '/admin/login'
          : window.routes?.adminRegister ?? '/admin/register'

      const body = new FormData()
      for (const k in this.form) {
        if (this.form[k] !== null) body.append(k, this.form[k])
      }
      body.append(
        '_token',
        document.querySelector('meta[name=csrf-token]').content
      )

      this.loading = true
      try {
        const headers = {
          'X-Requested-With': 'XMLHttpRequest',
          Accept: 'application/json'
        }
        const res = await fetch(url, { method: 'POST', headers, body })
        const text = await res.text()
        let payload
        try {
          payload = JSON.parse(text)
        } catch (e) {
          payload = { raw: text }
        }

        console.log('POST', url, res.status, payload)

        if (res.ok && payload.ok) {
          this.showToast(payload.message || 'Account created')
          this.mode = 'login'
          this.form.password = ''
          this.form.password_confirmation = ''
          if (payload.email) this.form.email = payload.email
          this.$nextTick(() => this.$refs?.adminEmail?.focus())
          return
        }

        if (payload.redirect) {
          window.location = payload.redirect
          return
        }

        this.open = false

        if (payload?.errors) {
          const first = Object.values(payload.errors)[0]
          this.error = Array.isArray(first) ? first[0] : first
          return
        }

        this.error = payload?.raw || 'Request failed, check console'
      } catch (err) {
        console.error('submit error', err)
        this.error = 'Network or Server error'
      } finally {
        this.loading = false
      }
    }
  }
}
