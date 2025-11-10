const btnVotar = document.querySelectorAll('.votar');

btnVotar.forEach(button => {
    button.addEventListener('click', () =>{
        const idcandidatura = this.dataset.candidatura
        const modalId = button.getAttribute('data-modal');
        const modal = document.getElementById(modalId);

        modal.showModal();
    });
});

const btnCandidatar = document.querySelectorAll('.candidatar')

btnCandidatar.forEach(button => {
    button.addEventListener('click', () =>{
        const modalId = button.getAttribute('data-modal');
        const modal = document.getElementById(modalId);

        modal.showModal();
    });
});

const btnCriarCandidatura= document.querySelectorAll('.criarCandidatura')

btnCriarCandidatura.forEach(button => {
    button.addEventListener('click', () =>{
        const modalId = button.getAttribute('data-modal');
        const modal = document.getElementById(modalId);

        modal.showModal();
    });
});

const btnCriarVotacao= document.querySelectorAll('.criarVotacao')

btnCriarVotacao.forEach(button => {
    button.addEventListener('click', () =>{
        const modalId = button.getAttribute('data-modal');
        const modal = document.getElementById(modalId);

        modal.showModal();
    });
});

const btnFechar = document.querySelectorAll('.cancelar');

    btnFechar.forEach(button => {
        button.addEventListener('click', () =>{
            const modalId = button.getAttribute('data-modal');
            const modal = document.getElementById(modalId);

            modal.close();
            
        });
    });

function botaoVotar() {
    const botaoVotar = document.querySelector(".confirmarVoto")
    botaoVotar.addEventListener('click', function(){
    const modal = document.getElementById('modal-candidatos');
    modal.close();
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            container: 'z-[9999] bg-black/50 backdrop-blur-sm font-sans',
            popup: 'border-2 rounded-xl shadow-xl p-6 bg-white',
            title: 'text-2xl font-bold text-black',
            confirmButton: 'bg-[#b20000] hover:bg-red-600 text-white font-medium px-4 py-2 rounded',
            cancelButton: 'bg-gray-200 hover:bg-gray-400 text-black font-medium px-4 py-2 rounded'
        },
        
        buttonsStyling: true
    });
    swalWithBootstrapButtons.fire({
        title: "Deseja confirmar seu voto?",
        text: "Após a confirmação do voto não sera possivel votar novamente",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Confirmar",
        cancelButtonText: "Cancelar",
        reverseButtons: true
    }).then((result) => {
    if (result.isConfirmed) {
    swalWithBootstrapButtons.fire({
      title: "Confirmado!",
      text: "Seu voto foi confirmado com sucesso.",
      icon: "success"
    });
    } else if (
        result.dismiss === Swal.DismissReason.cancel
    ) {
    modal.showModal();
    }
    });
})
}



function botaoCandidatar() {
    const botaoCandidatar = document.querySelector(".botaoCandidatar")
    botaoCandidatar.addEventListener('click', function(){
    const modal = document.getElementById('modal-formulario');
    modal.close();
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            container: 'z-[9999] bg-black/50 backdrop-blur-sm font-sans',
            popup: 'border-2 rounded-xl shadow-xl p-6 bg-white',
            title: 'text-2xl font-bold text-black',
            confirmButton: 'bg-[#b20000] hover:bg-red-600 text-white font-medium px-4 py-2 rounded',
            cancelButton: 'bg-gray-200 hover:bg-gray-400 text-black font-medium px-4 py-2 rounded'
        },
        
        buttonsStyling: true
    });
    swalWithBootstrapButtons.fire({
        title: "Deseja confirmar sua candidatura?",
        text: "Após a confirmação você será um candidato para a votação",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Confirmar",
        cancelButtonText: "Cancelar",
        reverseButtons: true
    }).then((result) => {
    if (result.isConfirmed) {
    swalWithBootstrapButtons.fire({
      title: "Confirmado!",
      text: "Sua candidatura foi realizado com sucesso.",
      icon: "success"
    });
    } else if (
        result.dismiss === Swal.DismissReason.cancel
    ) {
    modal.showModal();
    }
    });
})
}

function confirmarCandidatura() {
    const botaoConfirmarCandidatura = document.querySelector(".confirmarCandidatura")
    botaoConfirmarCandidatura.addEventListener('click', function(){
    const modal = document.getElementById('modal-formulario');
    modal.close();
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            container: 'z-[9999] bg-black/50 backdrop-blur-sm font-sans',
            popup: 'border-2 rounded-xl shadow-xl p-6 bg-white',
            title: 'text-2xl font-bold text-black',
            confirmButton: 'bg-[#b20000] hover:bg-red-600 text-white font-medium px-4 py-2 rounded',
            cancelButton: 'bg-gray-200 hover:bg-gray-400 text-black font-medium px-4 py-2 rounded'
        },
        
        buttonsStyling: true
    });
    swalWithBootstrapButtons.fire({
      title: "Sucesso!",
      text: "Candidaturas abertas.",
      icon: "success"
    });
    })
}

function confirmarVotacao() {
    const botaoConfirmarVotacao= document.querySelector(".confirmarVotacao")
    botaoConfirmarVotacao.addEventListener('click', function(){
    const modal = document.getElementById('modal-formulario');
    modal.close();
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            container: 'z-[9999] bg-black/50 backdrop-blur-sm font-sans',
            popup: 'border-2 rounded-xl shadow-xl p-6 bg-white',
            title: 'text-2xl font-bold text-black',
            confirmButton: 'bg-[#b20000] hover:bg-red-600 text-white font-medium px-4 py-2 rounded',
            cancelButton: 'bg-gray-200 hover:bg-gray-400 text-black font-medium px-4 py-2 rounded'
        },
        
        buttonsStyling: true
    });
    swalWithBootstrapButtons.fire({
      title: "Sucesso!",
      text: "Votações abertas.",
      icon: "success"
    });
    })
}

function excluirCandidatura() {
    const botaoExcluirCandidatura = document.querySelectorAll(".excluirCandidatura")
    botaoExcluirCandidatura.forEach(button => {
    button.addEventListener('click', function(){
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            container: 'z-[9999] bg-black/50 backdrop-blur-sm font-sans',
            popup: 'border-2 rounded-xl shadow-xl p-6 bg-white',
            title: 'text-2xl font-bold text-black',
            confirmButton: 'bg-[#b20000] hover:bg-red-600 text-white font-medium px-4 py-2 rounded',
            cancelButton: 'bg-gray-200 hover:bg-gray-400 text-black font-medium px-4 py-2 rounded'
        },
        
        buttonsStyling: true
    });
    swalWithBootstrapButtons.fire({
        title: "Deseja excluir a candidatura?",
        text: "Após a confirmação a candidatura será excluida permanentemente",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Confirmar",
        cancelButtonText: "Cancelar",
        reverseButtons: true
    });
    })
    })
}

function excluirVotacao() {
    const botaoExcluirVotacao = document.querySelectorAll(".excluirVotacao")
    botaoExcluirVotacao.forEach(button => {
    button.addEventListener('click', function(){
    const swalWithBootstrapButtons = Swal.mixin({
      customClass: {
        container: 'z-[9999] bg-black/50 backdrop-blur-sm font-sans',
        popup: 'border-2 rounded-xl shadow-xl p-6 bg-white',
        title: 'text-2xl font-bold text-black',
        confirmButton: 'bg-[#b20000] hover:bg-red-600 text-white font-medium px-4 py-2 rounded',
        cancelButton: 'bg-gray-200 hover:bg-gray-400 text-black font-medium px-4 py-2 rounded',
        htmlContainer: 'mb-4',
        actions: 'flex justify-center gap-2 mt-4',
        input: 'min-h-[200px] min-h-[150px]'
      },
      buttonsStyling: false
    });

    swalWithBootstrapButtons.fire({
    html: `
    <h2 class="text-xl font-bold text-black mb-4">Motivo da Exclusão:</h2>
    
    <textarea id="motivoExclusao" class="w-full min-h-[150px] p-2 border border-gray-300 rounded mb-4 resize-none focus:outline-none focus:ring-2 focus:ring-red-500"></textarea>
    
    <p class="text-gray-700 w-full">Após a confirmação a votação será excluida permanentemente</p>
  `,
      showCancelButton: true,
      confirmButtonText: "Confirmar",
      cancelButtonText: "Cancelar",
      reverseButtons: true,
    });
    })
})
}

document.addEventListener('DOMContentLoaded', () => {
  const btnCadastrar = document.querySelectorAll('.cadastrar');
  btnCadastrar.forEach(button => {
    const form = button.closest('form');
    if (!form) return;

    // garante tipo e action fallback absoluto
    button.type = 'button';
    if (!form.action || form.action.includes('app/view')) {
      form.action = `${window.location.origin}/cadastrar.php`;
      console.log('[cadastrar] form.action definido:', form.action);
    }

    button.addEventListener('click', (e) => {
      e.preventDefault();

      Swal.fire({
        position: "center",
        icon: "success",
        title: "Cadastro realizado com sucesso!",
        showConfirmButton: false,
        timer: 1500
      }).then(() => {
        // submete o form (em vez de redirecionar manualmente)
        form.submit();
      });
    });
  });
});

function candidatar() {
document.getElementById('btnCandidatar').addEventListener('click', function() {
  const btn = this;
  const acao = btn.dataset.candidatado === "true" ? "remover" : "cadastrar";
  const idaluno = btn.dataset.aluno;
  const idcandidatura = btn.dataset.candidatura;

  // URL chama o roteador
  const url = `/PI-semestre1/roteador.php?controller=Candidato&acao=${acao}`;
  
   fetch(url, {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded'},
    body: new URLSearchParams({ idaluno, idcandidatura })
  })
  .then(res => res.json())
  .then(data => {
    if (data.sucesso) {
      if (acao === 'cadastrar') {
        btn.innerText = 'REMOVER CANDIDATURA';
        btn.className = 'mx-auto w-[14rem] py-4 rounded-lg text-xl font-semibold text-white mt-auto bg-gray-600 hover:bg-gray-700'
        btn.dataset.candidatado = "true";
        mostrarModal('Candidatura confirmada com sucesso!');
      } else {
        btn.innerText = 'CANDIDATAR-SE';
        btn.className = 'mx-auto w-[14rem] py-4 rounded-lg text-xl font-semibold text-white mt-auto bg-[#b20000] hover:bg-red-600'
        btn.dataset.candidatado = "false";
        mostrarModal('Candidatura removida.');
      }
    } else {
      mostrarModal('Erro ao processar candidatura.');
    }
  })
  .catch(() => mostrarModal('Falha na comunicação com o servidor.'));
});

function mostrarModal(msg) {
  document.getElementById('mensagemModal').innerText = msg;
  document.getElementById('modalConfirmacao').style.display = 'flex';
}
}

function fecharModal() {
  document.getElementById('modalConfirmacao').style.display = 'none';
}