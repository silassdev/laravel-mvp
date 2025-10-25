export function adminAuth(){
  return {
    open: false,
    mode: 'login',
    loading: false,
    error: '',
    form: { email:'', fullname:'', username:'', password:'', password_confirmation:'', remember:false },
    toast: { show:false, message:'' },

    init(){
      window.addEventListener('open-admin', () => { this.open = true; this.$nextTick(()=>{ 
        try { if(this.$refs?.adminEmail) this.$refs?.adminEmail.focus(); }catch(e) {} }) });    },
    showToast(msg){ this.toast.message = msg; this.toast.show = true; setTimeout(()=> this.toast.show=false, 3500) },

    async submit(){
      this.error = '';
      if(this.mode==='signup' && (this.form.password.length < 6)) { this.error='Password must be at least 6 characters'; return; }
      if(this.mode==='signup' && this.form.password !== this.form.password_confirmation) { this.error='Passwords do not match'; return; }

      const url = (this.mode==='login') 
      ? (window.routes?.adminLogin ?? '/admin/login')
      : (window.routes?.adminRegister ?? '/admin/register');

      const body = new FormData();
      for(const k in this.form) if(this.form[k] !== null) body.append(k, this.form[k]);
      body.append('_token', document.querySelector('meta[name=csrf-token]').content);

      this.loading = true;
      try{
        const res = await fetch(url, { method:'POST', body });
        const data = await res.json();
        if(res.ok && data.ok){
          this.showToast(data.message || 'Success');
          if(data.redirect) return window.location = data.redirect;
          this.open = false;
        } else {
          this.error = data?.message || Object.values(await res.json())[0] || 'Error';
        }
      }catch(e){
        this.error = 'Network error';
      }finally{ this.loading = false; }
    }
  }
}
