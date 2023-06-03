import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { AlertController, LoadingController, ToastController } from '@ionic/angular';
import { environment } from 'src/environments/environment';

@Component({
  selector: 'app-login',
  templateUrl: './login.page.html',
  styleUrls: ['./login.page.scss'],
})
export class LoginPage implements OnInit {
  form: any = {};
  constructor(
    private loadingController: LoadingController,
    private alertController: AlertController,
    private router: Router,
    private toastController: ToastController
  ) { }

  ngOnInit() {
    this.checkToken();
  }

  async login() {
    if (!this.form.nis || !this.form.password) return this.toastController.create({
      message: 'NIS dan password harus diisi',
      duration: 2000,
      color: 'danger'
    }).then(toast => toast.present());

    try {
      const res = await fetch(environment.BASE_URL + 'login', {
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
        }).then(toast => toast.present());
      }

      localStorage.setItem('token', json.data.token);
      localStorage.setItem('role', json.data.user.role);

      this.router.navigate(['/tabs']);
      this.toastController.create({
        message: 'Login berhasil',
        duration: 2000,
        color: 'success'
      }).then(toast => toast.present());
    } catch (err) {

    }
  }

  checkToken() {
    if (localStorage.getItem('token')) {
      this.router.navigate(['/tabs/home']);
    }
  }


}
