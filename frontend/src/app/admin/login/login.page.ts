import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { ToastController } from '@ionic/angular';
import { environment } from 'src/environments/environment';

@Component({
  selector: 'app-login',
  templateUrl: './login.page.html',
  styleUrls: ['./login.page.scss'],
})
export class LoginPage implements OnInit {
  form: any = {};
  constructor(
    private toastController: ToastController,
    private router: Router
  ) { }

  ngOnInit() {
    this.checkToken();
  }

  async login() {
    try {
      const res = await fetch(environment.BASE_URL + 'login/admin', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(this.form)
      });

      const json = await res.json();
      if (res.status !== 200) {
        this.toastController.create({
          message: json.message,
          duration: 2000,
          color: 'danger'
        }).then((toast) => {
          toast.present();
        });
        return;
      }

      const data = json.data;
      localStorage.setItem('token', data.token);
      localStorage.setItem('role', data.user.role);

      this.toastController.create({
        message: 'Login berhasil',
        duration: 2000,
        color: 'success'
      }).then((toast) => {
        toast.present();
      });
      this.router.navigate(['/admin']);
    } catch (error: any) {
      this.toastController.create({
        message: error.message,
        duration: 2000,
        color: 'danger'
      }).then((toast) => {
        toast.present();
      });
    }
  }

  checkToken() {
    const token = localStorage.getItem('token');
    const role = localStorage.getItem('role');

    if (token && role) {
      if (role === 'user')
        this.router.navigate(['/tabs/home']);
      else if (role === 'admin')
        this.router.navigate(['/admin']);
    }
  }
}

