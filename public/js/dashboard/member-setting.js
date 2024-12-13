function showCreateModal() {
    toggleModal("createModal", false);
}

function toggleModal(modalId, isHidden) {
    const modal = document.getElementById(modalId);
    modal.classList.toggle("hidden", isHidden);
}

async function fetchData(url) {
    const response = await fetch(url);
    if (!response.ok) throw new Error("Data tidak ditemukan");
    return await response.json();
}

async function showDetail(id) {
    try {
        const data = await fetchData(`/alumni/${id}`);
        console.log("Detail Data:", data);

        const fields = [
            { label: "NIM", value: data.nim },
            { label: "Nama", value: data.nama },
            { label: "Tahun Masuk", value: data.tahun_masuk },
            { label: "Tahun Lulus", value: data.tahun_lulus },
            { label: "No. Telepon", value: data.no_telepon },
            { label: "Email", value: data.email },
            { label: "Alamat Rumah", value: data.alamat_rumah },
            { label: "IPK", value: data.ipk },
            { label: "LinkedIn", value: data.linkedin },
            { label: "Instagram", value: data.instagram },
            { label: "Email Alternatif", value: data.email_alternatif },
        ];

        document.getElementById("alumniDetail").innerHTML = fields
            .map(
                ({ label, value }) => `
                    <tr class="border-b">
                        <td class="py-2 px-4 font-medium text-white">${label}:</td>
                        <td class="py-2 px-4 text-white">${value ?? "-"}</td>
                    </tr>
                `
            )
            .join("");

        toggleModal("detailModal", false);
    } catch (error) {
        console.error("Error:", error);
        alert("Gagal mengambil data.");
    }
}

function closeModal(modalId) {
    toggleModal(modalId, true);
}

async function showEditModal(id) {
    try {
        const data = await fetchData(`/alumni/${id}`);
        console.log("Edit Data:", data); // Debugging

        const fields = [
            ["editNama", data.nama],
            [
                "editTahunMasuk",
                data.tahun_masuk ? parseInt(data.tahun_masuk) : "",
            ],
            [
                "editTahunLulus",
                data.tahun_lulus ? parseInt(data.tahun_lulus) : "",
            ],
            ["editNoTelepon", data.no_telepon],
            ["editEmail", data.email],
            ["editAlamatRumah", data.alamat_rumah],
            ["editIpk", data.ipk ? parseFloat(data.ipk).toFixed(2) : ""],
            ["editLinkedIn", data.linkedin],
            ["editInstagram", data.instagram],
            ["editEmailAlternatif", data.email_alternatif],
            ["editId", data.id],
        ];

        fields.forEach(([fieldId, value]) => {
            document.getElementById(fieldId).value = value ?? "";
        });

        const form = document.getElementById("editForm");
        form.action = form.action.replace(":id", id);

        toggleModal("editModal", false);
    } catch (error) {
        console.error("Error:", error);
        alert("Gagal mengambil data.");
    }
}

function deleteDetail(id) {
    if (!confirm("Anda yakin ingin menghapus data ini?")) return;

    fetch(`/alumni/${id}`, {
        method: "DELETE",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Content-Type": "application/json",
        },
    })
        .then((response) => {
            if (!response.ok) throw new Error("Gagal menghapus data.");
            return response.json();
        })
        .then(() => {
            alert("Data berhasil dihapus");
            location.reload();
        })
        .catch((error) => {
            console.error("Error:", error);
            alert(error.message);
        });
}
