import { register } from 'swiper/element/bundle';
import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { AlertController, LoadingController, ToastController } from '@ionic/angular';
import { environment } from 'src/environments/environment';

@Component({
  selector: 'app-signup',
  templateUrl: './signup.page.html',
  styleUrls: ['./signup.page.scss'],
})
export class SignupPage implements OnInit {
  classes: any = [];
  form: any = {};

  constructor(
    private router: Router,
    private alertController: AlertController,
    private loadingController: LoadingController,
    private toastController: ToastController,
  ) { }

  ngOnInit() {
    this.getAllClass();
  }

  async getAllClass() {
    const loading = await this.loadingController.create({
      message: 'Loading...'
    });

    await loading.present();
    try {
      const res = await fetch(`${environment.BASE_URL}kelas`, {
        headers: {
          'Content-Type': 'application/json'
        }
      });

      const json = await res.json();
      if (res.status !== 200) {
        this.alertController.create({
          header: 'Error',
          message: json.message,
          buttons: ['OK']
        }).then(alert => alert.present());
      }

      this.classes = json.data;
    } catch (err: any) {
      this.alertController.create({
        header: 'Error',
        message: err.message,
        buttons: ['OK']
      }).then(alert => alert.present());
    } finally {
      loading.dismiss();
    }
  }

  async register() {
    if (!this.form.name || !this.form.nis || !this.form.password || !this.form.id_kelas || !this.form.email) return this.toastController.create({
      message: 'Isi semua field',
      duration: 2000,
      color: 'danger'
    }).then(toast => toast.present());

    const loading = await this.loadingController.create({
      message: 'Loading...'
    });

    await loading.present();
    try {
      const res = await fetch(`${environment.BASE_URL}register`, {
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
        }).then(toast => {
          toast.present();
          loading.dismiss();
        });
      }

      localStorage.setItem('token', json.data.token);
      localStorage.setItem('role', json.data.user.role);

      this.router.navigate(['/tabs']);
      this.toastController.create({
        message: 'Register berhasil',
        duration: 2000,
        color: 'success'
      }).then(toast => {
        toast.present();
        loading.dismiss();
      });
    } catch (err: any) {
      this.toastController.create({
        message: err.message,
        duration: 2000,
        color: 'danger'
      }).then(toast => toast.present());
    }
  }
}
