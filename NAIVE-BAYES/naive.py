from __future__ import division

file = open("DATASET.csv", "rb")
parsed_file = file.read().split('\r\n')

for i in range(len(parsed_file)):
    parsed_file[i] = parsed_file[i].split(',')
del parsed_file[0]
del parsed_file[len(parsed_file)-1]
# print parsed_file

# probabilitas kelas
t_rawan = 0
t_aman = 0
for i in range(len(parsed_file)-1):
    if parsed_file[i][5] == '1':
        t_rawan += 1
    if parsed_file [i][5] == '0':
        t_aman += 1

# Probabilitas waktu dan kelas
p_pagi_rawan = 0
p_siang_rawan = 0
p_sore_rawan = 0
p_malam_rawan = 0
p_pagi_aman = 0
p_siang_aman = 0
p_sore_aman = 0
p_malam_aman = 0

p_m_rawan = 0
p_m_aman = 0
p_f_rawan = 0
p_f_aman = 0

p_desc_1_rawan = 0
p_desc_1_aman = 0
p_desc_0_rawan = 0
p_desc_0_aman = 0

for i in range(len(parsed_file)-1):
    if parsed_file[i][1] == 'pagi' and parsed_file[i][5] == '1':
        p_pagi_rawan += 1
    elif parsed_file[i][1] == 'pagi' and parsed_file[i][5] == '0':
        p_pagi_aman += 1

    elif parsed_file[i][1] == 'siang' and parsed_file[i][5] == '1':
        p_siang_rawan += 1
    elif parsed_file[i][1] == 'siang' and parsed_file[i][5] == '0':
        p_siang_aman += 1

    elif parsed_file[i][1] == 'sore' and parsed_file[i][5] == '1':
        p_sore_rawan += 1
    elif parsed_file[i][1] == 'sore' and parsed_file[i][5] == '0':
        p_sore_aman += 1

    elif parsed_file[i][1] == 'malam' and parsed_file[i][5] == '1':
        p_malam_rawan += 1
    elif parsed_file[i][1] == 'siang' and parsed_file[i][5] == '0':
        p_malam_aman += 1

    if parsed_file[i][3] == 'M' and parsed_file[i][5] == '1':
        p_m_rawan += 1
    elif parsed_file[i][3] == 'M' and parsed_file[i][5] == '0':
        p_m_aman += 1
    elif parsed_file[i][3] == 'F' and parsed_file[i][5] == '1':
        p_f_rawan += 1
    elif parsed_file[i][3] == 'F' and parsed_file[i][5] == '0':
        p_f_aman += 1

    if parsed_file[i][4] == '1' and parsed_file[i][5] == '1':
        p_desc_1_rawan += 1
    elif parsed_file[i][4] == '1' and parsed_file[i][5] == '0':
        p_desc_1_aman += 1
    elif parsed_file[i][4] == '0' and parsed_file[i][5] == '1':
        p_desc_0_rawan += 1
    elif parsed_file[i][4] == '0' and parsed_file[i][5] == '0':
        p_desc_0_aman += 1

p_pagi_rawan =  p_pagi_rawan/t_rawan
p_pagi_aman = p_pagi_aman/t_aman

p_siang_rawan = p_siang_rawan/t_rawan
p_siang_aman = p_siang_aman/t_aman

p_sore_rawan /= t_rawan
p_sore_aman /= t_aman

p_malam_rawan = p_malam_rawan/t_rawan
p_malam_aman /= t_aman

p_f_rawan /= t_rawan
p_f_aman /= t_aman
p_m_rawan /= t_rawan
p_f_aman /= t_aman

p_desc_1_rawan /= t_rawan
p_desc_1_aman /= t_aman
p_desc_0_rawan /= t_rawan
p_desc_0_aman /= t_aman

n_cops_dist_rawan = 0
n_cops_dist_aman = 0
t_cops_dist_rawan = 0
t_cops_dist_aman = 0

for i in range(len(parsed_file)-1):
    if parsed_file[i][5] == '1':
        n_cops_dist_rawan += 1
        t_cops_dist_rawan += float(parsed_file[i][2])
    else:
        n_cops_dist_aman += 1
        t_cops_dist_aman += float(parsed_file[i][2])

mean_cops_dist_rawan = t_cops_dist_rawan/n_cops_dist_rawan
mean_cops_dist_aman = t_cops_dist_aman/n_cops_dist_aman

var_cops_dist_rawan = 0
var_cops_dist_aman = 0

for i in range(len(parsed_file)-1):
    if parsed_file[i][5] == '1':
        var_cops_dist_rawan += (float(parsed_file[i][2])-mean_cops_dist_rawan)**2
    else:
        var_cops_dist_aman += (float(parsed_file[i][2])-mean_cops_dist_aman)**2

var_cops_dist_rawan /= n_cops_dist_rawan-1
var_cops_dist_aman /= n_cops_dist_aman-1

# p_cops_dist_rawan = 1/((2*3.14*var_cops_dist_rawan)**0.5)*e_rawan
# p_cops_dist_aman = 1/((2*3.14*var_cops_dist_aman)**0.5)*e_aman

input_waktu = str(input())
input_cops_dist = float(input())
input_sex = input()
input_desc = input()

if input_waktu == 'pagi':
    p_input_waktu_rawan = p_pagi_rawan
    p_input_waktu_aman = p_pagi_aman
elif input_waktu == 'siang':
    p_input_waktu_rawan = p_siang_rawan
    p_input_waktu_aman = p_siang_aman
elif input_waktu == 'sore':
    p_input_waktu_rawan = p_sore_rawan
    p_input_waktu_aman = p_sore_aman
elif input_waktu == 'malam':
    p_input_waktu_rawan = p_malam_rawan
    p_input_waktu_aman = p_m_aman

e_rawan = 2.72**(-1*((input_cops_dist-mean_cops_dist_rawan)**2)/(2*(var_cops_dist_rawan)))
input_p_cops_dist_rawan = 1/((2*3.14*var_cops_dist_rawan)**0.5)*e_rawan

e_aman = 2.72**(-1*((input_cops_dist-mean_cops_dist_aman)**2)/(2*(var_cops_dist_aman)))
input_p_cops_dist_aman = 1/((2*3.14*var_cops_dist_aman)**0.5)*e_aman

if input_sex == 'M':
    p_input_sex_rawan = p_m_rawan;
    p_input_sex_aman = p_m_aman
else:
    p_input_sex_rawan = p_f_rawan
    p_input_sex_aman = p_f_aman

if input_desc == '1':
    input_desc_rawan = p_desc_1_rawan
    input_desc_aman = p_desc_1_aman
else:
    input_desc_rawan = p_desc_0_rawan
    input_desc_aman = p_desc_0_aman

p_input_rawan = p_input_waktu_rawan*input_p_cops_dist_rawan*p_input_sex_rawan*input_desc_rawan
p_input_aman = p_input_waktu_aman*input_p_cops_dist_aman*p_input_sex_aman*input_desc_aman

print p_input_rawan
print p_input_aman

if p_input_rawan > p_input_aman:
    print "RAWAN"
else: print "AMANN"