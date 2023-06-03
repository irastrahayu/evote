import { Component, OnInit } from '@angular/core';
import { ModalController, ToastController } from '@ionic/angular';
import { environment } from 'src/environments/environment';

@Component({
  selector: 'app-add-pemilihan-modal',
  templateUrl: './add-pemilihan-modal.component.html',
  styleUrls: ['./add-pemilihan-modal.component.scss'],
})
export class AddPemilihanModalComponent implements OnInit {
  form: any = {};
  constructor(
    private modalController: ModalController,
    private toastController: ToastController
  ) { }

  ngOnInit() { }

  uploadFile(event: any) {
    const file = event.target.files[0];
    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = async () => {
      // save image to form
      this.form.image = file;
    };
  }

  async create() {
    if (!this.form.nama || !this.form.deskripsi || !this.form.tanggal_mulai || !this.form.tanggal_selesai || !this.form.image) {
      this.toastController.create({
        message: 'Semua field harus diisi',
        duration: 2000
      }).then(toast => toast.present());
      return;
    }

    try {
      const formData = new FormData();
      formData.append('image', this.form.image);
      formData.append('nama', this.form.nama);
      formData.append('deskripsi', this.form.deskripsi);
      formData.append('tanggal_mulai', this.form.tanggal_mulai);
      formData.append('tanggal_selesai', this.form.tanggal_selesai);

      const res = await fetch(`${environment.BASE_URL}admin/pemilihan`, {
        method: 'POST',
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('token')}`
        },
        body: formData
      });

      const json = await res.json();
      if (res.status !== 201) {
        this.toastController.create({
          message: json.message,
          duration: 2000
        }).then(toast => toast.present());

        return;
      }

      this.toastController.create({
        message: json.message,
        duration: 2000
      }).then(toast => toast.present());

      this.modalController.dismiss();
    } catch (err) {
      this.toastController.create({
        message: 'Terjadi kesalahan',
        duration: 2000
      }).then(toast => toast.present());
    }
  }

  close() {
    this.modalController.dismiss();
  }
}
