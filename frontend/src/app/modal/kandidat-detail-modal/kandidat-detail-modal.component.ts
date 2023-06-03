import { Component, Input, OnInit } from '@angular/core';
import { AlertController, ModalController, ToastController } from '@ionic/angular';
import { environment } from 'src/environments/environment';

@Component({
  selector: 'app-kandidat-detail-modal',
  templateUrl: './kandidat-detail-modal.component.html',
  styleUrls: ['./kandidat-detail-modal.component.scss'],
})
export class KandidatDetailModalComponent implements OnInit {
  selectedSegment = 'visi';
  @Input() data: any;
  @Input() isVoted: any;
  @Input() isClosed: any;

  constructor(
    private modalController: ModalController,
    private toastController: ToastController,
    private alertController: AlertController
  ) { }

  ngOnInit() { }

  close() {
    this.modalController.dismiss();
  }

  async vote() {
    const alert = await this.alertController.create({
      header: 'Konfirmasi',
      message: 'Apakah anda yakin ingin memilih kandidat ini?',
      buttons: [
        {
          text: 'Batal',
          role: 'cancel'
        },
        {
          text: 'Ya',
          handler: () => {
            this.voteHandler();
          }
        }
      ]
    });

    await alert.present();
  }

  async voteHandler() {
    try {
      const res = await fetch(`${environment.BASE_URL}pemilihan/${this.data.id_pemilihan}/vote/${this.data.id}`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${localStorage.getItem('token')}`
        }
      });

      const json = await res.json();
      if (res.status !== 200) {
        this.toastController.create({
          message: json.message,
          duration: 2000,
          color: 'danger'
        }).then(toast => toast.present());
        return;
      }

      this.modalController.dismiss('voted');
      this.toastController.create({
        message: json.message,
        duration: 2000,
        color: 'success'
      }).then(toast => toast.present());
    } catch (error: any) {
      this.toastController.create({
        message: error.message,
        duration: 2000,
        color: 'danger'
      }).then(toast => toast.present());
    }
  }
}
