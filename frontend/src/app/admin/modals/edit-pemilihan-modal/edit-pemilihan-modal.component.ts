import { Component, Input, OnInit } from '@angular/core';
import { ActivatedRoute, Route } from '@angular/router';
import { ModalController, ToastController } from '@ionic/angular';
import { environment } from 'src/environments/environment';

@Component({
  selector: 'app-edit-pemilihan-modal',
  templateUrl: './edit-pemilihan-modal.component.html',
  styleUrls: ['./edit-pemilihan-modal.component.scss'],
})
export class EditPemilihanModalComponent implements OnInit {
  @Input() data: any;

  form: any = {};

  constructor(
    private modalController: ModalController,
    private toastController: ToastController,
  ) {
  }

  ngOnInit() {
    console.log(this.data);
    this.form.nama = this.data.nama_pemilihan;
    this.form.deskripsi = this.data.deskripsi;
    this.form.status = this.data.status;
    this.form.tanggal_mulai = this.data.tanggal_mulai;
    this.form.tanggal_selesai = this.data.tanggal_selesai;
    this.form.__method = 'PUT';
  }

  close() {
    this.modalController.dismiss();
  }

  async update() {
    try {
      const options: any = {
        method: 'POST',
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('token')}`
        }
      }

      // check if image is updated
      if (this.form.image) {
        const formData = new FormData();
        formData.append('image', this.form.image);
        formData.append('__method', 'PUT');
        formData.append('nama', this.form.nama);
        formData.append('deskripsi', this.form.deskripsi);
        formData.append('status', this.form.status);
        formData.append('tanggal_mulai', this.form.tanggal_mulai);
        formData.append('tanggal_selesai', this.form.tanggal_selesai);

        options['body'] = formData;
      } else {
        options['body'] = JSON.stringify(this.form);
        options['headers']['Content-Type'] = 'application/json';
      }

      const res = await fetch(`${environment.BASE_URL}admin/pemilihan/${this.data.id}`, options);
      const json = await res.json();
      if (res.status !== 200) {
        this.toastController.create({
          message: json.message,
          duration: 2000,
          color: 'danger'
        }).then(toast => {
          toast.present();
        });

        return;
      }

      this.toastController.create({
        message: json.message,
        duration: 2000,
        color: 'success'
      }).then(toast => {
        toast.present();
        this.modalController.dismiss('updated');
      });
    } catch (err) {
      this.toastController.create({
        message: 'Error',
        duration: 2000,
        color: 'danger'
      }).then(toast => {
        toast.present();
      });
    }
  }

  uploadFile(event: any) {
    const file = event.target.files[0];
    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = async () => {
      // save image to form
      this.form.image = file;
    };
  }
}
