import { Component, OnInit } from '@angular/core';
import { AlertController, ModalController, ToastController, LoadingController } from '@ionic/angular';
import { AboutPage } from '../about/about.page';
import { SupportPage } from '../support/support.page';
import { Router } from '@angular/router';
import { EditProfileModalComponent } from '../modal/edit-profile-modal/edit-profile-modal.component';
import { environment } from 'src/environments/environment';

@Component({
  selector: 'app-setting',
  templateUrl: './setting.page.html',
  styleUrls: ['./setting.page.scss'],
})

export class SettingPage implements OnInit {
  user: any = {};
  constructor(
    private modalCtrl: ModalController,
    private alertController: AlertController,
    private router: Router,
    private toastController: ToastController,
    private loadingController: LoadingController
  ) { }

  ngOnInit() {
    this.getProfile();
  }

  editProfile() {
    this.modalCtrl.create({
      component: EditProfileModalComponent,
      componentProps: {
        user: this.user
      }
    }).then(modalres => {
      modalres.present();
    })
  }

  about() {
    this.modalCtrl.create({
      component: AboutPage
    }).then(modalres => {
      modalres.present();
    })
  }

  support() {
    this.modalCtrl.create({
      component: SupportPage
    }).then(modalres => {
      modalres.present();
    })

  }

  logout() {
    this.alertController.create({
      header: 'Logout',
      message: 'Apakah kamu yakin ingin logout?',
      buttons: [
        {
          text: 'Batal',
          role: 'cancel'
        },
        {
          text: 'Logout',
          handler: () => {
            localStorage.removeItem('token');
            localStorage.removeItem('role');

            this.router.navigate(['/welcome']);
          }
        }
      ]
    }).then(alert => alert.present());
  }

  async getProfile() {
    const loading = await this.loadingController.create({
      message: 'Loading...'
    });

    await loading.present();
    try {
      const res = await fetch(`${environment.BASE_URL}profile`, {
        headers: {
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${localStorage.getItem('token')}`
        }
      });

      const json = await res.json();
      if (res.status !== 200) {
        this.toastController.create({
          message: json.message,
          duration: 3000
        }).then(toast => {
          toast.present();
          loading.dismiss();
        });
      }

      this.user = json.data;
      loading.dismiss();
    } catch (err: any) {
      loading.dismiss();
      this.toastController.create({
        message: err.message,
        duration: 3000
      }).then(toast => toast.present());
    }
  }
}
