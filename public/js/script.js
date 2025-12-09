function votar(){
const btnVotar = document.querySelectorAll('.votar');

btnVotar.forEach(button => {
    button.addEventListener('click', () =>{
        window.candidatoSelecionado = null;
        const botao = button;
        const ideleicao = botao.dataset.ideleicao;
        const modalId = button.getAttribute('data-modal');
        const modal = document.getElementById(modalId);
        const tipo = botao.dataset.tipo;

        const url = `/PI-semestre2/roteador.php?controller=Candidato&acao=listar`;
  
        fetch(url, {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded'},
          body: new URLSearchParams({ideleicao})
        })
        .then(res => res.json())
        .then(data => {
          if (data.sucesso && data.candidatos) {
              // Preenche o modal com os candidatos
              const listaCandidatos = document.getElementById('listaCandidatos');
              listaCandidatos.innerHTML = "";

              data.candidatos.forEach(candidato => {
                const card = document.createElement('div');
                card.className = 'flex flex-col items-center gap-4 border-2 w-max p-4 rounded-md min-w-[12rem] snap-start shrink-0';
                card.innerHTML = `
                  <img class="w-40 h-40 object-cover rounded-full" 
                  src="../../../uploads/candidatos/${htmlEscape(candidato.imagem)}" 
                  onerror="this.src='../../../assets/user.png'"
                  alt="Foto do candidato">
                  <p class="text-lg font-semibold">${htmlEscape(candidato.nome)}</p>
                  `;

                if (tipo === "VOTACAO") {
                  const votos = document.createElement('p');
                  votos.textContent = `Votos: ${candidato.qtdVotos}`;
                  card.appendChild(votos);
                  
                }

                if (tipo === "VOTAR") {
                  const radio = document.createElement('input');
                  radio.type = "radio";
                  radio.name = "candidatoEscolhido"; // só permite 1 selecionado
                  radio.value = candidato.idcandidato;
                  radio.className = "w-4 h-4 text-red-600";
                  
                  // quando clicar, salvar o id do candidato escolhido
                  radio.addEventListener('change', () => {
                      window.candidatoSelecionado = radio.value;
                  });

                  // rótulo com texto "Selecione"
                  const label = document.createElement('label');
                  label.textContent = "Selecione";
                  label.className = "text-black text-lg font-medium";

                  const wrap = document.createElement('div');
                  wrap.className = "flex items-center gap-1";
                  wrap.appendChild(radio);
                  wrap.appendChild(label);

                  card.appendChild(wrap);
                }

                listaCandidatos.appendChild(card);
              });

              if (tipo === "VOTACAO") {

                  const cardNulo = document.createElement('div');
                  cardNulo.className = 
                      'flex flex-col items-center gap-4 border-2 w-max p-4 rounded-md min-w-[12rem] snap-start shrink-0 bg-gray-100';

                  cardNulo.innerHTML = `
                      <img class="w-40 opacity-40" src="../../../assets/user.png" alt="user">
                      <p class="text-lg font-semibold text-red-600">VOTOS NULOS</p>
                      <p class="text-lg font-semibold">Total: ${data.votosNulos}</p>
                  `;

                  listaCandidatos.appendChild(cardNulo);
              }

              if (tipo === "VOTAR") {
                                  const cardNulo = document.createElement('div');
              cardNulo.className = 'flex flex-col items-center gap-4 border-2 w-max p-4 rounded-md min-w-[12rem] snap-start shrink-0 bg-gray-100';

              cardNulo.innerHTML = `
                <img class="w-40 opacity-40" src="../../../assets/user.png" alt="user">
                <p class="text-lg font-semibold text-red-600">VOTO NULO</p>
              `;

              // input radio
              const radioNulo = document.createElement('input');
              radioNulo.type = "radio";
              radioNulo.name = "candidatoEscolhido";
              radioNulo.value = "NULO"; // <- identificador importante
              radioNulo.className = "w-4 h-4 text-red-600";

              // quando selecionado
              radioNulo.addEventListener('change', () => {
                  window.candidatoSelecionado = 'NULO';
              });

              // rótulo
              const labelNulo = document.createElement('label');
              labelNulo.textContent = "Selecionar";
              labelNulo.className = "text-black text-lg font-medium";

              const wrapNulo = document.createElement('div');
              wrapNulo.className = "flex items-center gap-2";

              wrapNulo.appendChild(radioNulo);
              wrapNulo.appendChild(labelNulo);

              cardNulo.appendChild(wrapNulo);

              // adiciona ao modal
              listaCandidatos.appendChild(cardNulo);
              }
              
              modal.showModal();
          } else {
            Swal.fire("Aviso", "Nenhum candidato encontrado.", "warning");
          }
        })
        .catch((err) => {
          console.error('Erro:', err);
          mostrarModal('error');
        });
        });
    });
    function htmlEscape(text) {
      const div = document.createElement('div');
      div.textContent = text;
      return div.innerHTML;
    }
}

function resultado(){
document.querySelectorAll('.resultado').forEach(btn => {
    btn.addEventListener('click', function () {
        const ideleicao = this.dataset.ideleicao;
        const idturma = this.dataset.idturma;
        const tipo = this.dataset.tipo; // ADMIN ou ALUNO

        let destino = '';

        if (tipo === 'administrador') {
            destino = `resultado_admin.php?ideleicao=${ideleicao}&idturma=${idturma}`;
        } else {
            destino = `resultado.php?ideleicao=${ideleicao}&idturma=${idturma}`;
        }

        window.location.href = destino;
    });
});
}

function confirmarVoto() {
    const btnConfirmarVoto = document.querySelectorAll('.confirmarVoto');

    btnConfirmarVoto.forEach(button => {
        button.addEventListener('click', () => {
            const botao = button;
            const ideleicao = botao.dataset.ideleicao;
            const idaluno = botao.dataset.idaluno;
            const idcandidato = window.candidatoSelecionado;
            const modalId = botao.getAttribute('data-modal');
            const modal = document.getElementById(modalId);

            if (!idcandidato) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Selecione um candidato!'
                });
                return;
            }

            // ✔ Fecha o diálogo ANTES do SweetAlert (resolve o problema!)
            modal.close();

            Swal.fire({
                title: "Confirmar voto",
                text: "Você confirma seu voto e concorda que ele será registrado com sua assinatura na ata?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#b20000",
                cancelButtonColor: "#505050",
                confirmButtonText: "Sim, confirmar voto",
                cancelButtonText: "Cancelar"
            }).then((result) => {

                if (!result.isConfirmed) return;

                const url = `/PI-semestre2/roteador.php?controller=Voto&acao=votar`;

                fetch(url, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({ idcandidato, idaluno, ideleicao })
                })
                .then(res => res.json())
                .then(data => {

                    if (data.sucesso) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Voto registrado com sucesso!'
                        }).then(() => location.reload());
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Falha ao registrar voto.'
                        });
                    }
                })
                .catch(err => {
                    console.error('Erro:', err);
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro inesperado ao votar.'
                    });
                });

            });
        });
    });
}


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
            if (modalId === 'modal-candidatos') {
            const listaCandidatos = document.getElementById('listaCandidatos');
            if (listaCandidatos) {
                listaCandidatos.innerHTML = ''; // Remove todos os cards
            }
            }

            if (modalId === 'modal-formulario') {
                const form = modal.querySelector('form');
                if (form) {
                    form.reset(); // Limpa inputs do formulário
                }
            }
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

/*function excluirCandidatura() {
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
}*/

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

/*document.addEventListener('DOMContentLoaded', () => {
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
});*/

function candidatar() {
    const btn = document.getElementById('btnCandidatar');

    btn.addEventListener('click', () => {
        const jaCandidatado = btn.dataset.candidatado === "true";

        if (jaCandidatado) {
            // Se já está candidatado → remover normalmente
            removerCandidatura(btn);
        } else {
            // Se NÃO está → abrir modal de upload
            abrirModalUpload(btn.dataset.aluno, btn.dataset.eleicao);
        }
    });
}

let alunoSelecionado = null;
let eleicaoSelecionada = null;
let arquivoImagem = null;

// ABRIR MODAL
function abrirModalUpload(idaluno, ideleicao) {
    alunoSelecionado = idaluno;
    eleicaoSelecionada = ideleicao;

    document.getElementById("modalUpload").classList.remove("hidden");
}

// FECHAR MODAL
function fecharModalUpload() {
    document.getElementById("modalUpload").classList.add("hidden");
    document.getElementById("inputImagem").value = "";
    document.getElementById("previewImagem").classList.add("hidden");
}

// INPUT DE IMAGEM + PREVIEW
document.addEventListener("change", (e) => {
    if (e.target.id === "inputImagem") {
        const file = e.target.files[0];
        arquivoImagem = file;

        if (file) {
            const preview = document.getElementById("previewImagem");
            preview.src = URL.createObjectURL(file);
            preview.classList.remove("hidden");
        }
    }
});

// CONFIRMAR CANDIDATURA
function confirmarCandidatura() {

    if (!arquivoImagem) {
        Swal.fire({
            icon: "warning",
            title: "Envie uma foto!",
            text: "É necessário enviar uma foto para registrar a candidatura."
        });
        return;
    }

    const form = new FormData();
    form.append("idaluno", alunoSelecionado);
    form.append("ideleicao", eleicaoSelecionada);
    form.append("imagem", arquivoImagem);

    fetch(`/PI-semestre2/roteador.php?controller=Candidato&acao=cadastrar`, {
        method: "POST",
        body: form
    })
    .then(res => res.json())
    .then(data => {
        fecharModalUpload();

        if (data.sucesso) {
            Swal.fire({
                icon: "success",
                title: "Candidatura registrada!"
            }).then(() => location.reload());
        } else {
            Swal.fire({
                icon: "error",
                title: "Falha ao cadastrar!"
            });
        }
    })
    .catch(err => {
        Swal.fire({
            icon: "error",
            title: "Erro inesperado",
            text: err
        });
    });
}

// REMOVER CANDIDATURA (já existia)
function removerCandidatura(btn) {
    const idaluno = btn.dataset.aluno;
    const ideleicao = btn.dataset.eleicao;

    fetch(`/PI-semestre2/roteador.php?controller=Candidato&acao=remover`, {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: new URLSearchParams({ idaluno, ideleicao })
    })
    .then(res => res.json())
    .then(data => {
        if (data.sucesso) {
            Swal.fire({
                icon: "success",
                title: "Candidatura removida!"
            }).then(() => location.reload());
        }
    });
}


function excluirCandidatura() {
const btnExcluirCandidatura = document.querySelectorAll('.excluirCandidatura');

btnExcluirCandidatura.forEach(button => {
    button.addEventListener('click', () =>{
        const botao = button;
        const ideleicao = botao.dataset.ideleicao;

        const url = `/PI-semestre2/roteador.php?controller=Eleicao&acao=excluir`;
  
        fetch(url, {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded'},
          body: new URLSearchParams({ideleicao})
        })
        .then(res => res.json())
        .then(data => {
          if (data.sucesso) {
            const card = document.getElementById(`candidatura-${ideleicao}`);
            if (card) card.remove();
            mostrarModal('Excluido com sucesso.');
          } else {
            mostrarModal('Não foi possivel excluir a candidatura.');
          }
        })
        .catch((err) => {
          console.error('Erro:', err);
          mostrarModal('error' . err);
        });
        });
    });
    function mostrarModal(msg) {
      document.getElementById('mensagemModal').innerText = msg;
      document.getElementById('modalConfirmacao').style.display = 'flex';
    }
}